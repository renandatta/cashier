<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\RawMaterial;
use Faker\Generator as Faker;

$factory->define(RawMaterial::class, function (Faker $faker) {
    return [
        'raw_material_category_id' => rand(1, 4),
        'code' => mt_rand(000000000, 999999999),
        'name' => $faker->sentence(rand(4, 6)),
        'tag' => $faker->sentence(rand(1, 2)),
        'description' => $faker->sentence(rand(8, 12)),
        'stock' => 0,
        'price' => rand(5000, 20000),
        'image' => 'https://picsum.photos/id/'. mt_rand(000, 100) .'/400',
        'unit' => 'pcs'
    ];
});
