<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Office;
use Illuminate\Http\Request;

 
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class OfficeController extends Controller
{

    public function Index(Request $req)
    {
        $filters = $req->only(['search', 'perPage']);
    
        $perPage = is_numeric($filters['perPage'] ?? null) ? (int)$filters['perPage'] : 5;
        // return $filters ;
        $offices = Office::with('city')
            ->filter($filters) 
            ->paginate($perPage)
            ->withQueryString();
    
        return inertia('Offices/Index', [
            'offices' => $offices,
            'filters' => $filters,
        ]);
    }

        public function Create ( ) {
            $cities = City::select('id', 'name')->get();
            return Inertia::render('Offices/Create', [
                'cities' => $cities
            ]);
        }
        public function Store(Request $req)
        {
             $validated = $req->validate([
                'office_name' => [ 'required', 'string', 'max:255', Rule::unique('offices', 'office_name'), ],
                'manager_name' => 'required|string|max:255',
                'phone'        => 'required|string|max:20',
                'email'        => [ 'required', 'email', 'max:255',  Rule::unique('offices', 'email'), ],
                'city_id'      => 'required|exists:cities,id',
                'location'     => 'required|string|max:500',
            ],  );
        
             $office = new Office();
            $office->office_name  = $validated['office_name'];
            $office->manager_name = $validated['manager_name'];
            $office->phone        = $validated['phone'];
            $office->email        = $validated['email'] ;
            $office->city_id      = $validated['city_id'];
            $office->location     = $validated['location'] ;
            $office->save();
 
            return redirect()->back() ;
        }
 
        public function Edit(  $id)
        { 
            $office = Office::findOrFail($id);
            $cities = City::orderBy('name')->get();
   
            return inertia('Offices/Edit', [
                'office' => $office,
                'cities' => $cities,
            ]);
        }
        public function Update( Request  $req)
        { 
                         $validated = $req->validate([
                            'id' => 'required|exists:offices,id',
                            'office_name' => [
                                'required',
                                'string',
                                'max:255',
                                Rule::unique('offices', 'office_name')->ignore($req->id),
                            ],
                            'manager_name' => 'required|string|max:255',
                            'phone' => 'required|string|max:20',
                            'email' => [
                                'nullable',
                                'email',
                                'max:255',
                                Rule::unique('offices', 'email')->ignore($req->id),
                            ],
                            'city_id' => 'required|exists:cities,id',
                            'location' => 'nullable|string|max:500',
                        ]);

                         $office = \App\Models\Office::findOrFail($req->id);

                        $office->office_name = $validated['office_name'];
                        $office->manager_name = $validated['manager_name'];
                        $office->phone = $validated['phone'];
                        $office->email = $validated['email'] ?? null;
                        $office->city_id = $validated['city_id'];
                        $office->location = $validated['location'] ?? null;
                        $office->save();
   
            return redirect()->back() ;
        }
 
        public function Delete ($id  ) {
            Office::find($id )->delete() ;
            return redirect()->back() ;
        }

}
