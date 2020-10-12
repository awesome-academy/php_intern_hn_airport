<?php

use Illuminate\Database\Seeder;

class DatabaseSeederV2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ConfigDistanceSeeder::class,
            ConfigBasicSeeder::class,
        ]);
    }
}
