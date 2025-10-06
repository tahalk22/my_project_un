<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CityController extends Controller
{
             public function Index (Request $req ) 
    {
          $filters = $req->only(['name']);

            $cities = City::query()
                ->filter($filters)
                ->latest()
                ->paginate(10)
                ->appends($filters);

            return Inertia::render('Cities/Index', [
                'cities' => $cities,
                'filters' => $filters,
            ]);
    }
 
    public function Create()
    {
       return Inertia::render('Cities/Create'); 
    }

public function Store(Request $request)
{
    $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:cities,name'],
    ]);

      City::create($validated);

      return redirect()->back() ; 
}

 

    /**
     * Show the form for editing the specified resource.
     */
    public function Edit(  $id)
    {
        $city  = City::findOrFail($id);
    return Inertia::render('Cities/Edit', ['city' => $city]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function  Update(Request $req )
    {
            $validated = $req->validate([
               'id' => ['required', 'exists:cities,id'],
                'name' => ['required', 'string', 'max:255', 'unique:cities,name,' . $req->id],
            ]);

         City::where('id', $req->id)->update(['name' => $validated['name']]);

           return redirect() -> back() ; 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Delete(  $id)
    {
                $color =  City::find($id)->delete();
            if (   $color ) 
                return redirect() -> back() ;
            else 
            return redirect() -> back()->withErrors([]) ;  
      } 
}
