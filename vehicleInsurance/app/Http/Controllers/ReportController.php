<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Office;
use App\Models\Claim;
use App\Models\Insurance;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


 
use App\Models\User;
 
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function OverView()
{
            $top_offices = Office::select('office_name')
                ->withCount('insurances')
                ->orderByDesc('insurances_count')
                ->take(5)
                ->get();
        // return 22 ;
            $claims_stats = Claim::select('claim_status', DB::raw('count(*) as count'))
                ->groupBy('claim_status')
                ->pluck('count', 'claim_status');

            return Inertia::render('Reports/OverView', [
                'top_offices' => $top_offices,
                'claims_stats' => $claims_stats,
            ]);
}

public function InsuranceReports(Request $req)
{
    $user = Auth::user();

    $filters = $req->only(['from_date', 'to_date', 'user_id', 'office_id', 'per_page']);

    $query = Insurance::with([
        'car_type:id,name',
        'country:id,name',
        'color:id,name',
        'clause:id,name',
        'user:id,name',
        'office:id,office_name',
    ])
    ->when($filters['from_date'] ?? false, fn($q, $v) =>
        $q->whereDate('version_date', '>=', $v))
    ->when($filters['to_date'] ?? false, fn($q, $v) =>
        $q->whereDate('version_date', '<=', $v))
    ->when($filters['user_id'] ?? false, fn($q, $v) =>
        $q->where('user_id', $v))
    ->when($filters['office_id'] ?? false, fn($q, $v) =>
        $q->where('office_id', $v));

    if ($user->user_level > 2 && $user->office_id) {
        $query->where('office_id', $user->office_id);
    }

    $perPage = intval($filters['per_page'] ?? 10);
    $insurances = $query->latest()->paginate($perPage)->appends($filters);

    $offices = ($user->user_level <= 2)
        ? Office::select('id', 'office_name')->get()
        : Office::where('id', $user->office_id)->select('id', 'office_name')->get();

    $users = ($user->user_level <= 2)
        ? User::select('id', 'name')->get()
        : User::where('office_id', $user->office_id)->select('id', 'name')->get();

    return Inertia::render('Reports/InsuranceReports', [
        'filters' => $filters,
        'total' => $insurances->total(),
        'insurances' => $insurances,
        'users' => $users,
        'offices' => $offices,
        'auth' => ['user' => $user],
    ]);
}


public function ClaimReports(Request $req)
{
    $user = Auth::user();

    $filters = $req->only([
        'insurance_name',
        'plate_number',
        'user_id',
        'office_id',
        'claim_id', 
        'insurance_id',
        'claim_type',
        'claim_status',
        'date_from',
        'date_to'
    ]);

    $query = Claim::query()->with(['insurance', 'insurance.office', 'insurance.user']);

    if ($user->user_level > 2 && $user->office_id) {
        $query->whereHas('insurance', fn($i) => $i->where('office_id', $user->office_id));
    }

    $query
        ->when($filters['insurance_name'] ?? false, fn($q, $v) =>
            $q->whereHas('insurance', fn($i) => $i->where('insurance_name', 'like', "%$v%")))
        ->when($filters['plate_number'] ?? false, fn($q, $v) =>
            $q->whereHas('insurance', fn($i) => $i->where('plate_number', 'like', "%$v%")))
        ->when($filters['user_id'] ?? false, fn($q, $v) =>
            $q->whereHas('insurance', fn($i) => $i->where('user_id', $v)))
        ->when($filters['office_id'] ?? false, fn($q, $v) =>
            $q->whereHas('insurance', fn($i) => $i->where('office_id', $v)))  
        ->when($filters['claim_type'] ?? false, fn($q, $v) => $q->where('claim_type', $v))
        ->when($filters['claim_status'] ?? false, fn($q, $v) => $q->where('claim_status', $v))
        ->when($filters['date_from'] ?? false, fn($q, $v) => $q->whereDate('claim_date', '>=', $v))
        ->when($filters['date_to'] ?? false, fn($q, $v) => $q->whereDate('claim_date', '<=', $v)) 
        ->when($filters['claim_id'] ?? false, fn($q, $v) => $q->where('id' , $v)) 
        ->when($filters['insurance_id'] ?? false, fn($q, $v) => $q->where('insurance_id', $v));

    $claims = $query->latest()->get();

    $results = $claims->map(function ($claim) {
        return [
            'id' => $claim->id,
            'policy_number' => $claim->insurance->id,
            'insurance_name' => $claim->insurance->insurance_name,
            'plate_number' => $claim->insurance->plate_number,
            'claim_type' => $claim->claim_type,
            'claim_status' => $claim->claim_status,
            'claim_date' => $claim->claim_date,
            'office_name' => $claim->insurance->office?->office_name ?? 'الفرع الرئيسي',
            'user_name' => $claim->insurance->user?->name ?? '—',
        ];
    });

    $offices = ($user->user_level <= 2)
        ? Office::select('id', 'office_name')->get()
        : Office::where('id', $user->office_id)->select('id', 'office_name')->get();

    $users = ($user->user_level <= 2)
        ? User::select('id', 'name')->get()
        : User::where('office_id', $user->office_id)->select('id', 'name')->get();

    return Inertia::render('Reports/ClaimReports', [
        'results' => $results,
        'filters' => $filters,
        'offices' => $offices,
        'users' => $users,
        'total' => $claims->count(),
    ]);
}

 



}
