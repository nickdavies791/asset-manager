<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Role::class)->create([
        	'name' => 'Read'
		]);
        factory(App\Role::class)->create([
        	'name' => 'Contribute'
		]);
        factory(App\Role::class)->create([
        	'name' => 'Administrator'
		]);
    }
}
