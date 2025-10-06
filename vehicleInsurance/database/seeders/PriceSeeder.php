<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Price::create([
            "id"   => 1 , 
            "installment"   => 64.0  , 
            "tax" =>  1.0 , 
            "supervision" =>  0.5 , 
            "stamp" => 1.0   , 
            "version" => 2.0   , 
           ]) ;
    }
}
