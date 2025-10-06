<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

 
use Inertia\Inertia;

class PriceController extends Controller
{
  
    public function Edit()
    {
                $prices = Price::first();  
                return Inertia::render('Prices/Edit', [
               'prices' => $prices,
                ]); 
    }

    public function Update(Request $req)
{
                $validated = $req->validate([
                    'id' => ['required', 'exists:prices,id'],
                    'installment' => ['required', 'numeric', 'min:0'],
                    'tax' => ['required', 'numeric', 'min:0'],
                    'supervision' => ['required', 'numeric', 'min:0'],
                    'stamp' => ['required', 'numeric', 'min:0'],
                    'version' => ['required', 'numeric', 'min:0'],
                ]);

                Price::where('id', $req->id)->update($validated);

                return redirect()->back()->with('success', 'تم تحديث الأسعار بنجاح');
}

 
}
