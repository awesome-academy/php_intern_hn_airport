<?php

use App\Models\CarType;
use App\Models\Province;
use App\Models\ProvinceAirport;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            ProvinceSeeder::class,
            CarTypeSeeder::class,
            ProvinceAirportSeeder::class,
            UserSeeder::class,
        ]);
    }
}
