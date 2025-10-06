<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Company::create([
        "id"   => 1  , 
        "name" => " المختار للتأمين" , 
        "phone" => "09222222" , 
        "email" => "s@gmail.com" , 
        "logo" => "logo/logo.png" , 
        "city_id"    => "1" , 
        "location" => "جزيرة مجمع الدهماني" ,
       ]) ;
        
 

    }
}
