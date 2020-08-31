<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('car_types')->insert([
            ['type' => '4'],
            ['type' => '5'],
            ['type' => '7'],
            ['type' => '9'],
            ['type' => '16'],
            ['type' => '29'],
            ['type' => '35'],
            ['type' => '45'],
            ['type' => 'Limousine 9'],
            ['type' => 'Limousine 17'],
        ]);
    }
}
