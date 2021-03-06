<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$this->call(RolesTableSeeder::class);
		$this->call(SchoolsTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(CategoriesTableSeeder::class);
		$this->call(TypesTableSeeder::class);
		$this->call(AssetsTableSeeder::class);
		$this->call(FinancesTableSeeder::class);
	}
}
