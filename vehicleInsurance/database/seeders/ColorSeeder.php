<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    
    public function run(): void
    {
            Color::create([
            "name"   =>  "أزرق"  , 
           ]) ;
            Color::create([
            "name"   =>  "أسود"  , 
           ]) ;
            Color::create([
            "name"   =>  "أزرق كحلي"  , 
           ]) ;
            Color::create([
            "name"   =>  "أحمر"  , 
           ]) ;
    }
}
