<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 
        Office::create([ 
            "company_id" =>  1 , 
            "office_name" => "مكتب الفرناج" , 
            "manager_name" => "فتحي عيسى" , 
            "email" => "sOffice@gmail.com" ,  
            "phone" => "0924061212" ,  
            "city_id"    => "1" , 
            "location" => "طرابلس الفرناج" ,
           ]) ;
            


    }
}
