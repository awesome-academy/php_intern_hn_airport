<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('123'),
        'remember_token' => Str::random(10),
        'phone' => $faker->regexify('(0)[0-9]{9}'),
        'role_id' => rand(1,4),
        'status' => 1,
    ];
});
