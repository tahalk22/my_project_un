<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
   
 
    public function Index () {
      $is_maintenance =   Maintenance::first() ;
    //   return     $is_maintenance   ;
        return  inertia ("Maintenance/Index" , ["is_maintenance" => $is_maintenance]) ;
    }
    public function TurnOnServer () {
        Maintenance::first()->update(['is_maintenance' => 2  ]) ;
        return redirect()->back() ;
    }
    public function TurnOffServer () {
        Maintenance::first()->update(['is_maintenance' => 1  ]) ;
        return redirect()->back() ;
    }


    public function MaintenancePage () {
       $is_maintenance =  Maintenance::first()->is_maintenance  ;
 
        if ($is_maintenance == 2 )
          {  return inertia ("Maintenance/MaintenancePage") ;}
        //   {  return  view('Maintenance.Maintenance'); }
        else if  ($is_maintenance == 1  )
    {    return redirect()->route('Index');}
    return 222 ;
    }

}
