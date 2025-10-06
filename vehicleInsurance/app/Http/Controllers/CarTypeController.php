<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarTypeController extends Controller
{

    public function Index(Request $req)
        {
            $filters = $req->only(['name', 'country_id']);

            $carTypes =   CarType::with('country')
                ->filter($filters)
                ->latest()
                ->paginate(10)
                ->appends($filters);

            $countries =  Country::select('id', 'name')->get();

            return Inertia::render('CarTypes/Index', [
                'carTypes' => $carTypes,
                'countries' => $countries,
                'filters' => $filters,
            ]);
        }

            public function Create()
            {
                $countries =  Country::select('id', 'name')->get();

                return Inertia::render('CarTypes/Create', [
                    'countries' => $countries
                ]);
            }


            public function Edit($id)
            {
                $car_type =  CarType::findOrFail($id);
                $countries =  Country::select('id', 'name')->get();

                return Inertia::render('CarTypes/Edit', [
                    'car_type' => $car_type,
                    'countries' => $countries,
                ]);
            }

           public function Update(Request $req)
            {
                $validated = $req->validate([
                    'id' => ['required', 'exists:car_types,id'],
                    'name' => ['required', 'string', 'max:255', 'unique:car_types,name,' . $req->id],
                    'country_id' => ['required', 'exists:countries,id'],
                ]);

                 CarType::where('id', $req->id)->update($validated);

                return redirect()->back() ;
            }



            public function Store(Request $request)
            {
                $validated = $request->validate([
                   'name' => ['required', 'string', 'max:255', 'unique:car_types,name'],
                    'country_id' => ['required', 'exists:countries,id'],
                ]);

                CarType::create($validated);

                return redirect()->route('CarTypes.Create')->with('success', 'تمت إضافة نوع السيارة بنجاح');
            }

            public function Delete (  $id )      {
                $car_type =  CarType::find($id)->delete();
                    if (   $car_type ) 
                        return redirect() -> back() ;
                    else 
                    return redirect() -> back()->withErrors([]) ;  
           }



            }
