<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigDistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_distances')->insert([
            [
                'min' => '0',
                'max' => '10',
            ],
            [
                'min' => '10',
                'max' => '20',
            ],
            [
                'min' => '20',
                'max' => '500',
            ],
        ]);
    }
}
