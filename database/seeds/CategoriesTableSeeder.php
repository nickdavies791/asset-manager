<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class)->create([
        	'name' => 'Server'
		]);
        factory(App\Category::class)->create([
        	'name' => 'Laptop'
		]);
        factory(App\Category::class)->create([
        	'name' => 'Tablet'
		]);
        factory(App\Category::class)->create([
        	'name' => 'Land'
		]);
        factory(App\Category::class)->create([
        	'name' => 'Building'
		]);
    }
}
