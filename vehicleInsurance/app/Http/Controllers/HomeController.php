<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Insurance;
 
use App\Models\Office;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function Dashboard()
    {
             $user = Auth::user();

     $insuranceQuery = Insurance::query();
    $claimQuery = Claim::query();
    $userQuery = User::query();

    if (in_array($user->user_level, [3, 4])) {
         $insuranceQuery->where('office_id', $user->office_id);
        $userQuery->where('office_id', $user->office_id);
        $claimQuery->whereHas('insurance', fn($q) => $q->where('office_id', $user->office_id));
    }

    $stats = [
        'total_insurances' => $insuranceQuery->count(),
        'total_offices'    => in_array($user->user_level, [1, 2]) ? Office::count() : 1,
        'total_users'      => $userQuery->count(),
        'total_claims'     => $claimQuery->count(),
        'claims_by_type' => [
            'accident' => $claimQuery->clone()->where('claim_type', 1)->count(),
            'damage'   => $claimQuery->clone()->where('claim_type', 2)->count(),
        ],
    ];

    return Inertia::render('Dashboard', ['stats' => $stats]);
}
 
}
