<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Staff;
use Faker\Generator as Faker;

$factory->define(Staff::class, function (Faker $faker) {
    return [
        'no_id' => mt_rand(0000000000, 9999999999),
        'name' => $faker->name
    ];
});
