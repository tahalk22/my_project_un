<?php

namespace Database\Seeders;

use App\Models\CarType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarType::create([
            "id" => 1 , 
            "name" => "افانتي الاغبيا", 
            "country_id" => 1 , 
        ]) ;
        CarType::create([
            "id" => 2 , 
            "name" => "افانتي منفوخة", 
            "country_id" => 1 , 
        ]) ;
        CarType::create([
            "id" => 3 , 
            "name" => " هيونداي ازيرا", 
            "country_id" => 1 , 
        ]) ;

        CarType::create([
            "id" => 4 , 
            "name" => "جيب", 
            "country_id" => 2  , 
        ]) ;
    }
}
