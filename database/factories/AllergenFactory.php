<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Allergen::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
    ];
});
