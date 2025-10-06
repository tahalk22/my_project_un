<?php

namespace App\Http\Controllers;

use App\Models\Clause;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClauseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index(Request $req) 
    {
            $filters = $req ->only(['name', 'type', 'per_page']);

            $clauses = Clause::query()
                ->filter($filters)
                ->latest()
                ->paginate($filters['per_page'] ?? 10)
                ->appends($filters);

            return inertia('Clauses/Index', [
                'clauses' => $clauses,
                'filters' => $filters,
            ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
         return inertia("Clauses/Create") ;
    }

    /**
     * Store a newly created resource in storage.
     */
public function Store(Request $request)
{
    $validated = $request->validate([
        'type' => ['required', 'in:1,2'], // 1 = PV, 2 = CV
        'name' => ['required', 'string', 'max:255'],
    ]);

    Clause::create( [
                'type' => $request->type , 
                'name' =>  $request->name ,  
                'additional_fee_per_year' => $request->type  == 2 ?  $request->additional_fee_per_year :  0  ,  
            ]);

    return redirect()->back()->with('success', 'تم حفظ البند بنجاح');
}

 

    /**
     * Show the form for editing the specified resource.
     */
    public function Edit( $id)
    {
            $clause = Clause::findOrFail($id);
            return Inertia::render('Clauses/Edit', ['clause' => $clause]);
    }

    /**
     * Update the specified resource in storage.
     */
public function Update(Request $req)
{
    $validated = $req->validate([
        'id' => ['required', 'exists:clauses,id'],
        'type' => ['required', 'in:1,2'],
        'name' => ['required', 'string', 'max:255'],
    ]);

    Clause::where('id', $req->id)->update([
        'type' => $validated['type'],
        'name' => $validated['name'],
      'additional_fee_per_year' => $validated['type']  == 2 ?   $req['additional_fee_per_year']    :  0  ,  
    ]);

       return redirect() -> back() ; 
}
public function Delete (  $id )
{
   $user =  Clause::find($id)->delete();
    if (   $user ) 
        return redirect() -> back() ;
    else 
    return redirect() -> back()->withErrors([]) ;  
}

}
