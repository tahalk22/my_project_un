<?php

namespace Database\Seeders;

use App\Models\Clause;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClauseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Clause::create([
            "type"   => 1  , 
            "name" => "سيارة خاصة مللاكي " , 
          "additional_fee_per_year" =>  0  , 
           ]) ;

           Clause::create([
            "type"   => 1  , 
            "name" => "دراجة نارية" , 
           "additional_fee_per_year" =>  0  , 
           ]) ;

           Clause::create([
            "type"   => 1  , 
            "name" => "سيارة تعليم قيادة" , 
           "additional_fee_per_year" =>  0  , 
           ]) ;

           Clause::create([
            "type"   => 1  , 
            "name" => "سيارة نقل موتى" , 
            "additional_fee_per_year" =>  0  , 
           ]) ;

           Clause::create([
            "type"   => 1  , 
            "name" => "سيارة اسعاف" , 
            "additional_fee_per_year" =>  0  , 
           ]) ;

           Clause::create([
            "type"   => 2  , 
            "name" => "المقطورة" , 
            "additional_fee_per_year" =>  30.0  , 
           ]) ;
           Clause::create([
            "type"   => 2  , 
            "name" => "السيارات التجارية" , 
                    "additional_fee_per_year" =>  30.0  , 
           ]) ;

           Clause::create([
            "type"   => 2  , 
            "name" => "  سيارات نقل البضائع" , 
                  "additional_fee_per_year" =>  30.0  , 
           ]) ;
           Clause::create([
            "type"   => 2  , 
            "name" => "  سيارات   الركوب والحافلات" , 
                     "additional_fee_per_year" =>  30.0  , 
           ]) ;

    }
}
