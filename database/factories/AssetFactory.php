<?php

use Faker\Generator as Faker;

$factory->define(App\Asset::class, function (Faker $faker) {
    return [
    	'tag' => $faker->ean8,
        'name' => $faker->catchPhrase
    ];
});
