<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{


    
 
    public function Dashboard() {
        $stats = [
            'total_participants' => User::whereHas('participant')->count(),
            'local_participants' => User::whereHas('participant', fn($q) => $q->where('participant_type', 1))->count(),
            'foreign_participants' => User::whereHas('participant', fn($q) => $q->where('participant_type', 2))->count(),
            'accepted' => User::where('status', 2)->whereHas('participant')->count(),
            'rejected' => User::where('status', 3)->whereHas('participant')->count(),
            'pending' => User::where('status', 1)->whereHas('participant')->count(),
            // الإحصائيات الجديدة
            'forum_only' => User::whereHas('participant', fn($q) => $q->where('attendance_type', 1))->count(),
            'courses_only' => User::whereHas('participant', fn($q) => $q->where('attendance_type', 2))->count(),
            'both' => User::whereHas('participant', fn($q) => $q->where('attendance_type', 3))->count(),
            'total_forum' => User::whereHas('participant', fn($q) => $q->whereIn('attendance_type', [1, 3]))->count(),
            'total_courses' => User::whereHas('participant', fn($q) => $q->whereIn('attendance_type', [2, 3]))->count()
        ];
        
        return inertia('Dashboard', ['stats' => $stats]);
    }
    
    
    public function AdminProfile () {
        $user = User::findOrFail(Auth::id());
 
        return inertia('Profile/AdminProfile', [
            'user' => $user,
         ]);
    }


    public function AdminProfileUpdate(Request $request)
    {
   
        $user = User::findOrFail(Auth::id());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:1|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        // Update profile photo if provided
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }
    
        $user->save();
    
        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
    


}
 

