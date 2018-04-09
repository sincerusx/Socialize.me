<?php

use Faker\Generator as Faker;

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

/** @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Entities\User::class, function (Faker $faker) {
    return [
            'username' => $faker->userName,
            // 'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm' /* secret */
            'password'       => bcrypt('secret'),
            'email'          => $faker->unique()->safeEmail,
            'activated'      => 1,
            'isReal'         => (string)0,
            'remember_token' => str_random(10),
            'created_at'     => date("Y-m-d H:i:s"),
    ];
});
