<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use App\Models\Clause;
use App\Models\Color;
use App\Models\Country;
use App\Models\Insurance;
use App\Models\Office;
use App\Models\Price;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InsuranceController extends Controller
{
 

public function Index(Request $req)
{
    $user = Auth::user();

    $users = match (true) {
        $user->user_level <= 2 => User::select('id', 'name', 'user_level')->get(),   
        default => User::where('office_id', $user->office_id)->select('id', 'name', 'user_level')->get(),
    };

    $filters = $req->only(['insurance_name', 'from_date', 'to_date', 'office_id', 'user_id', 'per_page']);

    $query = Insurance::with([
        'car_type',
        'office',
        'country',
        'color',
        'clause',
        'user',
    ])
    ->withCount('claims')  
    ->filter($filters);

    if (in_array($user->user_level, [3, 4])) {
        $query->where('office_id', $user->office_id);
    }

    $insurances = $query->latest('version_date')
        ->paginate($filters['per_page'] ?? 10)
        ->appends($filters);

    $offices = ($user->user_level <= 2)
        ? Office::select('id', 'office_name')->get()
        : [];

    return Inertia::render('Insurances/Index', [
        'insurances' => $insurances,
        'filters' => $filters,
        'offices' => $offices,
        'users' => $users,
    ]);
}


    public function Create()
{
    $countries = Country::all();
    $car_types = CarType::all();
    $clauses = Clause::all();
    $colors = Color::all();
    $prices = Price::first(); 
    return Inertia::render('Insurances/Create', [
        'countries' => $countries,
        'car_types' => $car_types,
        'clauses' => $clauses,
        'colors' => $colors,
        'prices' => $prices, 
    ]);
}

public function Store(Request $req)
{
    $validated = $req->validate([
        'insurance_name' => ['required', 'string'],
        'insurance_location' => ['required', 'string'],
        'phone' => ['required', 'string', 'max:20'],
        'id_type' => ['required', 'in:1,2'],
        'id_number' => ['required', 'string', 'max:50'],

        'chassis_number' => ['required', 'string'],
        'motor_number' => ['required', 'string'],
        'motor_power' => ['required', 'string'],
        'plate_number' => ['required', 'string'],
        'non_driver_passengers' => ['required', 'numeric'],
        'made_year' => ['required', 'numeric'],
        'years_number' => ['required', 'numeric'],
        'country_id' => ['required', 'exists:countries,id'],
        'car_type_id' => ['required', 'exists:car_types,id'],
        'clause_id' => ['required', 'exists:clauses,id'],
        'color_id' => ['required', 'exists:colors,id'],
        'installment' => ['required', 'numeric'],
        'tax' => ['required', 'numeric'],
        'supervision' => ['required', 'numeric'],
        'stamp' => ['required', 'numeric'],
        'version' => ['required', 'numeric'],
        'total' => ['required', 'numeric'],
    ]);
    $user = Auth::user()  ;
 
    $version_date = now();
    $from_date = Carbon::make($version_date)->addDay()->setTime(12, 0, 0); //      
    $to_date = (clone $from_date)->addYears($validated['years_number']);
 
    $clause = Clause::findOrFail($validated['clause_id']);
    $additional = ($clause->type == 2 && $clause->additional_fee_per_year > 0)
        ? $clause->additional_fee_per_year * $validated['years_number']
        : 0;

$total = (
    $validated['installment'] +
    $validated['tax'] +
    $validated['supervision'] +
    $validated['stamp'] +
    $validated['version'] +
    $additional
);

$validated['total'] = round($total, 3); 

    $validated['version_date'] = $version_date;
    $validated['from_date'] = $from_date;
    $validated['to_date'] = $to_date;

     $validated['user_id'] =  $user->id  ;
    if (  $user->user_level > 2 )
    $validated['office_id'] =  Auth::user()->office_id  ;
 

      $insurance =  Insurance::create($validated);

    return redirect()->back() ;
 }

public function Show($id)
{
  
    $insurance =  Insurance::with([
        'user', 'office', 'car_type', 'country', 'color', 'clause'
    ])->findOrFail($id);
 
    return Inertia::render('Insurances/Show', [
        'insurance' => $insurance,
    ]);
}


}
