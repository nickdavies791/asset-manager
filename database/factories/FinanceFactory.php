<?php

use Faker\Generator as Faker;

$factory->define(App\Finance::class, function (Faker $faker) {
    return [
        'asset_id' => \App\Asset::all()->random()->id,
        'accounting_start' => '2018-09-01',
        'accounting_end' => '2019-09-01',
        'purchase_date' => '2019-05-01',
        'end_of_life' => '2022-05-01',
        'purchase_cost' => $faker->randomFloat(2, 100, 5000),
        'current_value' => $faker->randomFloat(2, 100, 5000),
        'depreciation' => $faker->randomFloat(2, 100, 1000),
        'net_book_value' => $faker->randomFloat(2, 100, 5000),
        'transferred_at' => null
    ];
});
