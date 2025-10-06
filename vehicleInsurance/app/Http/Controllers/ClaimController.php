<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ClaimController extends Controller
{

 
    public function Index(Request $req)
        {
            $user = Auth::user();
            $filters = $req->only(['insurance_id', 'date_from', 'date_to', 'claim_status']);

 
            $insurances = match (true) {
                $user->user_level <= 2 =>   Insurance::where('office_id', $user->office_id)->get() , 
                default => Insurance::where('office_id', $user->office_id)->get(),
            };
 
                    $claims = Claim::with('insurance')
                        ->when($user->user_level > 2 && $user->office_id, function ($query) use ($user) {
                            $query->whereHas('insurance', fn($q) => $q->where('office_id', $user->office_id));
                        })
                        ->filter($filters)
                        ->latest()
                        ->paginate(20)
                        ->appends($filters);

                    return Inertia::render('Claims/Index', [
                        'claims' => $claims,
                        'filters' => $filters,
                        'insurances' => $insurances,
                    ]);
        }


    public function Create()
            {
                $user = Auth::user();

                if (in_array($user->user_level, [1, 2])) { 
                    $insurances = Insurance::latest()
                        ->get();
                } else { 
                    $insurances = Insurance::where('office_id', $user->office_id)
                        ->latest()
                        ->get();
                }

                return Inertia::render('Claims/Create', [
                    'insurances' => $insurances
                ]);
            }

    public function Store(Request $req)
        {
            $req->validate([
                'insurance_id' => 'required|exists:insurances,id',
                'claim_type' => 'required|in:1,2',
                'claim_date' => 'required|date',
                'description' => 'nullable|string',
                'attachments.0' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            ]);
 
            $attachment_paths = [];
            if ($req->hasFile('attachments')) {
                foreach ($req->file('attachments') as $file) {
                    $path = $file->store('claims', 'public');
                    $attachment_paths[] = $path;
                }
            }
 
            Claim::create([
                'insurance_id' => $req->insurance_id,
                'claim_type' => $req->claim_type,
                'claim_date' => $req->claim_date,
                'description' => $req->description,
                'attachments' => json_encode($attachment_paths, JSON_UNESCAPED_UNICODE),
                'claim_status' => 1,  
            ]);

            return redirect()->back();
        }

         public function UnderProcessing(  $id)
            {
                $claim = Claim::find($id) ; 
                    $claim->update([
                        'claim_status' => 2,  
                        'deny_reason' => null,
                    ]);

                    return back()->with('success', 'تم قبول المطالبة بنجاح.');
            }
         public function Accept(  $id)
            {
                $claim = Claim::find($id) ; 
                $claim->update([
                    'claim_status' => 3,  
                    'deny_reason' => null,
                ]);

                return back()->with('success', 'تم قبول المطالبة بنجاح.');
            }

        public function Deny(Request $req, Claim $claim)
            {
            
                $req->validate([
                    'deny_reason' => 'required|string|min:3'
                ]); 

                $claim->update([
                    'claim_status' => 4,  
                    'deny_reason' => $req->deny_reason,
                ]);

                return back()->with('success', 'تم رفض المطالبة بنجاح.');
            }


    public function Show($id)
        {
            $claim =  Claim::with('insurance')->findOrFail($id);

            return Inertia::render('Claims/Show', [
                'claim' => $claim,
            ]);
        }


}
