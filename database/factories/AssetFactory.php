<?php

use Faker\Generator as Faker;

$factory->define(App\Asset::class, function (Faker $faker) {
    return [
    	'school_id' => App\School::inRandomOrder()->first(),
    	'tag' => $faker->ean8,
        'name' => $faker->sentence(2),
        'serial_number' => $faker->sentence(6),
        'make' => $faker->word,
        'model' => $faker->word,
        'processor' => $faker->sentence(3),
        'memory' => $faker->sentence(2),
        'storage' => $faker->word,
        'operating_system' => $faker->word,
        'warranty' => $faker->sentence(2),
        'notes' => $faker->text,
    ];
});
