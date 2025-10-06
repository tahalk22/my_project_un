<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index (Request $req ) 
    {
          $filters = $req->only(['name']);

            $countries = Country::query()
                ->filter($filters)
                ->latest()
                ->paginate(10)
                ->appends($filters);

            return Inertia::render('Countries/Index', [
                'countries' => $countries,
                'filters' => $filters,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
       return Inertia::render('Countries/Create'); 
    }

public function Store(Request $req)
{
    $validated = $req->validate([
            'name' => ['required', 'string', 'max:255', 'unique:countries,name'],
    ]);

      Country::create($validated);

    return redirect()->back() ;
}

 

    /**
     * Show the form for editing the specified resource.
     */
    public function Edit(  $id)
    {
        $country = Country::findOrFail($id);
         return Inertia::render('Countries/Edit', ['country' => $country]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function  Update(Request $req )
    {
            $validated = $req->validate([
               'id' => ['required', 'exists:colors,id'],
                'name' => ['required', 'string', 'max:255', 'unique:countries,name,' . $req->id],
            ]);

         Country::where('id', $req->id)->update(['name' => $validated['name']]);

           return redirect() -> back() ; 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Delete(  $id)
    {
                $country =  Country::find($id)->delete();
            if (   $country ) 
                return redirect() -> back() ;
            else 
            return redirect() -> back()->withErrors([]) ;  
      }
}
