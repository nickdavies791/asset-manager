<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 3)->create();
        factory(App\User::class)->create([
        	'name' => 'Nick Davies',
			'email' => 'admin@admin.com',
			'password' => bcrypt('secret')
		]);
    }
}
