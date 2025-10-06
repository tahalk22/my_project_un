<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
          
        
            CountrySeeder::class,
            CarTypeSeeder::class,

            CitySeeder::class, 
            
            CompanySeeder::class ,
            OfficeSeeder::class ,
            UserSeeder::class,
            PriceSeeder::class,
            ColorSeeder::class,
            ClauseSeeder::class,
       
            MaintenanceSeeder::class,

        ]);
    }
}
