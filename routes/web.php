<?php
 
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CarTypeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ClauseController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CountryController;
 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\OfficeController;
 
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
 
 
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
 
  Route::get('/Insurances/Show/{id}',   [InsuranceController::class , 'Show' ]  )->name('Insurances.Show');  

Route::get('/Maintenance/MaintenancePage',   [MaintenanceController::class , 'MaintenancePage' ]  )->name('Maintenance.MaintenancePage');

Route::middleware([
    'maintenance',
])->group(function () { 
 

Route::get('/ForgotPassword' , function () {
    return Inertia::render('Auth/ForgotPassword' ); 
} )->name('ForgotPassword') ;
 


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
   
])->group(function () {

    Route::get('/Profile/Profile', [ UserController::class, 'Profile'])->name('Profile.Profile');
    Route::post('/Profile/ProfileUpdate', [ UserController::class, 'ProfileUpdate'])->name('Profile.ProfileUpdate');

    Route::get('/', [ HomeController::class, 'Dashboard'])->name('Dashboard');
    Route::get('/test',  function () {
        return inertia('test' ) ;
    }) ;

    Route::get('/Insurances/Create',   [InsuranceController::class , 'Create' ]  )->name('Insurances.Create');
    Route::post('/Insurances/Store',   [InsuranceController::class , 'Store' ]  )->name('Insurances.Store'); 

    Route::get('/Insurances/Edit/{id}',   [InsuranceController::class , 'Edit' ]  )->name('Insurances.Edit');
    Route::put('/Insurances/Update',   [InsuranceController::class , 'Update' ]  )->name('Insurances.Update');
    Route::delete('/Insurances/Delete/{id}',   [InsuranceController::class , 'Delete' ]  )->name('Insurances.Delete');
    Route::get('/Insurances/Index',   [InsuranceController::class , 'Index' ]  )->name('Insurances.Index');


    Route::get('/Claims/Create',   [ClaimController::class , 'Create' ]  )->name('Claims.Create');
    Route::post('/Claims/Store',   [ClaimController::class , 'Store' ]  )->name('Claims.Store'); 

    Route::get('/Claims/Edit/{id}',   [ClaimController::class , 'Edit' ]  )->name('Claims.Edit');
    Route::put('/Claims/Update',   [ClaimController::class , 'Update' ]  )->name('Claims.Update');
    Route::delete('/Claims/Delete/{id}',   [ClaimController::class , 'Delete' ]  )->name('Claims.Delete');
    Route::get('/Claims/Index',   [ClaimController::class , 'Index' ]  )->name('Claims.Index');
    Route::get('/Claims/UnderProcessing/{id}',   [ClaimController::class , 'UnderProcessing' ]  )->name('Claims.UnderProcessing');
    Route::get('/Claims/Accept/{id}',   [ClaimController::class , 'Accept' ]  )->name('Claims.Accept');
    Route::post('/Claims/{claim}/Deny', [ClaimController::class, 'Deny'])->name('Claims.Deny');
    Route::get('/Claims/Show/{id}',   [ClaimController::class , 'Show' ]  )->name('Claims.Show');


    Route::get('/Reports/OverView',   [ReportController::class , 'OverView' ]  )->name('Reports.OverView');
    Route::get('/Reports/ClaimReports',   [ReportController::class , 'ClaimReports' ]  )->name('Reports.ClaimReports');
    Route::get('/Reports/InsuranceReports',   [ReportController::class , 'InsuranceReports' ]  )->name('Reports.InsuranceReports');

    Route::middleware([
        'is_office_admin', 
        ])->group(function () {     
          Route::get('/Users/Index',   [UserController::class , 'Index' ]  )->name('Users.Index');
           Route::get('/Users/Create',   [UserController::class , 'Create' ]  )->name('Users.Create');
           Route::post('/Users/Store',   [UserController::class , 'Store' ]  )->name('Users.Store');
           Route::get('/Users/Edit/{id}',   [UserController::class , 'Edit' ]  )->name('Users.Edit');
           Route::post('/Users/Update',   [UserController::class , 'Update' ]  )->name('Users.Update');
           Route::delete('/Users/Delete/{id}',   [UserController::class , 'Delete' ]  )->name('Users.Delete');

        }); 




    Route::middleware([
        'is_company_admin', 
        ])->group(function () {  
            Route::get('/Offices/Create',   [OfficeController::class , 'Create' ]  )->name('Offices.Create');
            Route::post('/Offices/Store',   [OfficeController::class , 'Store' ]  )->name('Offices.Store'); 
            Route::get('/Offices/Edit/{id}',   [OfficeController::class , 'Edit' ]  )->name('Offices.Edit');
            Route::post('/Offices/Update',   [OfficeController::class , 'Update' ]  )->name('Offices.Update');
            Route::delete('/Offices/Delete/{id}',   [OfficeController::class , 'Delete' ]  )->name('Offices.Delete');
            Route::get('/Offices/Index',   [OfficeController::class , 'Index' ]  )->name('Offices.Index');


            Route::get('/Countries/Create',   [CountryController::class , 'Create' ]  )->name('Countries.Create');
            Route::post('/Countries/Store',   [CountryController::class , 'Store' ]  )->name('Countries.Store'); 
            Route::get('/Countries/Edit/{id}',   [CountryController::class , 'Edit' ]  )->name('Countries.Edit');
            Route::put('/Countries/Update',   [CountryController::class , 'Update' ]  )->name('Countries.Update');
            Route::delete('/Countries/Delete/{id}',   [CountryController::class , 'Delete' ]  )->name('Countries.Delete');
            Route::get('/Countries/Index',   [CountryController::class , 'Index' ]  )->name('Countries.Index');

             Route::get('/CarTypes/Create',   [CarTypeController::class , 'Create' ]  )->name('CarTypes.Create');
            Route::post('/CarTypes/Store',   [CarTypeController::class , 'Store' ]  )->name('CarTypes.Store'); 
            Route::get('/CarTypes/Edit/{id}',   [CarTypeController::class , 'Edit' ]  )->name('CarTypes.Edit');
            Route::put('/CarTypes/Update',   [CarTypeController::class , 'Update' ]  )->name('CarTypes.Update');
            Route::delete('/CarTypes/Delete/{id}',   [CarTypeController::class , 'Delete' ]  )->name('CarTypes.Delete');
            Route::get('/CarTypes/Index',   [CarTypeController::class , 'Index' ]  )->name('CarTypes.Index');


            Route::get('/Clauses/Create',   [ClauseController::class , 'Create' ]  )->name('Clauses.Create');
            Route::post('/Clauses/Store',   [ClauseController::class , 'Store' ]  )->name('Clauses.Store');
            // Route::get('/Offices/Edit/{id}',   function () { return 22 ;}  )->name('Offices.Edit');
            Route::get('/Clauses/Edit/{id}',   [ClauseController::class , 'Edit' ]  )->name('Clauses.Edit');
            Route::post('/Clauses/Update',   [ClauseController::class , 'Update' ]  )->name('Clauses.Update');
            Route::delete('/Clauses/Delete/{id}',   [ClauseController::class , 'Delete' ]  )->name('Clauses.Delete');
            Route::get('/Clauses/Index',   [ClauseController::class , 'Index' ]  )->name('Clauses.Index');



            Route::get('/Prices /Edit',   [PriceController::class , 'Edit' ]  )->name('Prices.Edit');
            Route::put('/Prices /Update',   [PriceController::class , 'Update' ]  )->name('Prices.Update');


             Route::get('/Colors/Create',   [ColorController::class , 'Create' ]  )->name('Colors.Create');
            Route::post('/Colors/Store',   [ColorController::class , 'Store' ]  )->name('Colors.Store'); 
            Route::get('/Colors/Edit/{id}',   [ColorController::class , 'Edit' ]  )->name('Colors.Edit');
            Route::put('/Colors/Update',   [ColorController::class , 'Update' ]  )->name('Colors.Update');
            Route::delete('/Colors/Delete/{id}',   [ColorController::class , 'Delete' ]  )->name('Colors.Delete');
            Route::get('/Colors/Index',   [ColorController::class , 'Index' ]  )->name('Colors.Index');

             Route::get('/Cities/Create',   [CityController::class , 'Create' ]  )->name('Cities.Create');
            Route::post('/Cities/Store',   [CityController::class , 'Store' ]  )->name('Cities.Store'); 
            Route::get('/Cities/Edit/{id}',   [CityController::class , 'Edit' ]  )->name('Cities.Edit');
            Route::put('/Cities/Update',   [CityController::class , 'Update' ]  )->name('Cities.Update');
            Route::delete('/Cities/Delete/{id}',   [CityController::class , 'Delete' ]  )->name('Cities.Delete');
            Route::get('/Cities/Index',   [CityController::class , 'Index' ]  )->name('Cities.Index');


         }); 
 


    Route::middleware([
        'is_super_admin', 
        ])->group(function () { 
            Route::resource("/Countries" , CountryController::class ) ;
            
            Route::get('/Maintenance/Index',   [MaintenanceController::class , 'Index' ]  )->name('Maintenance.Index');
            Route::get('/Maintenance/TurnOffServer',   [MaintenanceController::class , 'TurnOffServer' ]  )->name('Maintenance.TurnOffServer');
            Route::get('/Maintenance/TurnOnServer',   [MaintenanceController::class , 'TurnOnServer' ]  )->name('Maintenance.TurnOnServer');
                // TurnOnServer  TurnOffServer  MaintenanceController

    
    

           
         });

});



Route::middleware(['guest'])->group(function () { 
    Route::post('/Login', [AuthController::class, 'Login'])->name('Login');



});
 

} ) ;
