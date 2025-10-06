<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create([
            "id"   => 1  , 
            "name" => "طرابلس" ,  
           ]) ;
        City::create([
            "id"   => 2  , 
            "name" => "مصراته" ,  
           ]) ;
        City::create([
            "id"   => 3  , 
            "name" => "بنغازي" ,  
           ]) ;
        City::create([
            "id"   => 4   , 
            "name" => "بني وليد" ,  
           ]) ;
    }
}
