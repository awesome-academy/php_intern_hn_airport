<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigBasicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carTypes = DB::table('car_types')->get()->toArray();
        
        DB::table('config_basics')->insert([
            [
                'distance_id' => 1,
                'car_type_id' => array_search(4, array_column($carTypes, 'type')) + 1,
                'cost' => 10000,
            ],
            [
                'distance_id' => 1,
                'car_type_id' => array_search(5, array_column($carTypes, 'type')) + 1,
                'cost' => 10000,
            ],
            [
                'distance_id' => 1,
                'car_type_id' => array_search(7, array_column($carTypes, 'type')) + 1,
                'cost' => 13000,
            ],
            [
                'distance_id' => 1,
                'car_type_id' => array_search(16, array_column($carTypes, 'type')) + 1,
                'cost' => 16000,
            ],
            [
                'distance_id' => 2,
                'car_type_id' => array_search(4, array_column($carTypes, 'type')) + 1,
                'cost' => 8000,
            ],
            [
                'distance_id' => 2,
                'car_type_id' => array_search(5, array_column($carTypes, 'type')) + 1,
                'cost' => 8000,
            ],
            [
                'distance_id' => 2,
                'car_type_id' => array_search(7, array_column($carTypes, 'type')) + 1,
                'cost' => 11000,
            ],
            [
                'distance_id' => 2,
                'car_type_id' => array_search(16, array_column($carTypes, 'type')) + 1,
                'cost' => 14000,
            ],
            [
                'distance_id' => 3,
                'car_type_id' => array_search(4, array_column($carTypes, 'type')) + 1,
                'cost' => 6000,
            ],
            [
                'distance_id' => 3,
                'car_type_id' => array_search(5, array_column($carTypes, 'type')) + 1,
                'cost' => 6000,
            ],
            [
                'distance_id' => 3,
                'car_type_id' => array_search(7, array_column($carTypes, 'type')) + 1,
                'cost' => 9000,
            ],
            [
                'distance_id' => 3,
                'car_type_id' => array_search(16, array_column($carTypes, 'type')) + 1,
                'cost' => 12000,
            ],
        ]);
    }
}
