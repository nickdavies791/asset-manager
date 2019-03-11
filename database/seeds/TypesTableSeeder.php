<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Type::class)->create([
        	'name' => 'Freehold Property'
		]);
        factory(App\Type::class)->create([
        	'name' => 'Leasehold Property'
		]);
        factory(App\Type::class)->create([
        	'name' => 'Assets Under Construction'
		]);
        factory(App\Type::class)->create([
        	'name' => 'Motorvehicles'
		]);
        factory(App\Type::class)->create([
        	'name' => 'Fixtures Fittings and Equipment'
		]);
        factory(App\Type::class)->create([
        	'name' => 'IT Equipment'
		]);
    }
}
