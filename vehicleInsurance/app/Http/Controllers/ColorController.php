<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index (Request $req ) 
    {
          $filters = $req->only(['name']);

            $colors = Color::query()
                ->filter($filters)
                ->latest()
                ->paginate(10)
                ->appends($filters);

            return Inertia::render('Colors/Index', [
                'colors' => $colors,
                'filters' => $filters,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
       return Inertia::render('Colors/Create'); 
    }

public function Store(Request $request)
{
    $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:colors,name'],
    ]);

      Color::create($validated);

      return redirect()->back() ; 
}

 

    /**
     * Show the form for editing the specified resource.
     */
    public function Edit(  $id)
    {
        $color = Color::findOrFail($id);
    return Inertia::render('Colors/Edit', ['color' => $color]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function  Update(Request $req )
    {
            $validated = $req->validate([
               'id' => ['required', 'exists:colors,id'],
                'name' => ['required', 'string', 'max:255', 'unique:colors,name,' . $req->id],
            ]);

         Color::where('id', $req->id)->update(['name' => $validated['name']]);

           return redirect() -> back() ; 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Delete(  $id)
    {
                $color =  Color::find($id)->delete();
            if (   $color ) 
                return redirect() -> back() ;
            else 
            return redirect() -> back()->withErrors([]) ;  
      }
}
