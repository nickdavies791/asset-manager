<?php

namespace Tests\Feature;

use App\Asset;
use App\Category;
use App\Role;
use App\School;
use App\Type;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAssetFinanceValidationTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test an asset ID is required
	 */
	public function test_asset_id_is_required()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'asset_id' => null,
		]);
		$response->assertSessionHasErrors('asset_id');
		$this->assertEquals(session('errors')->get('asset_id')[0], 'An asset was not provided');
	}

	/*
	 * Test the asset provided does exist in the database
	 */
	public function test_asset_id_exists()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'asset_id' => 99999999,
		]);
		$response->assertSessionHasErrors('asset_id');
		$this->assertEquals(session('errors')->get('asset_id')[0], 'The asset provided does not exist');
	}

	/*
	 * Test the accounting start date is a date
	 */
	public function test_accounting_start_is_date()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'accounting_start' => 12345,
		]);
		$response->assertSessionHasErrors('accounting_start');
		$this->assertEquals(session('errors')->get('accounting_start')[0], 'The accounting start date is not in the correct format');
	}

	/*
	 * Test the accounting end date is a date
	 */
	public function test_accounting_end_is_date()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'accounting_end' => 12345,
		]);
		$response->assertSessionHasErrors('accounting_end');
		$this->assertEquals(session('errors')->get('accounting_end')[0], 'The accounting end date is not in the correct format');
	}

	/*
	 * Test accounting start date is before the end of the assets life
	 */
	public function test_accounting_start_date_is_before_end_of_life_date()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'accounting_start' => '2019-01-01',
			'end_of_life' => '2018-01-01'
		]);
		$response->assertSessionHasErrors('accounting_start');
		$this->assertEquals(session('errors')->get('accounting_start')[0], 'This asset has already depreciated to the end of its life');
	}

	/*
	 * Test the purchase date is in the correct format
	 */
	public function test_purchase_date_is_date()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'purchase_date' => 12345,
		]);
		$response->assertSessionHasErrors('purchase_date');
		$this->assertEquals(session('errors')->get('purchase_date')[0], 'The purchase date is not in the correct format');
	}

	/*
	 * Test the end of life date is a date
	 */
	public function test_end_of_life_is_date()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'end_of_life' => 12345,
		]);
		$response->assertSessionHasErrors('end_of_life');
		$this->assertEquals(session('errors')->get('end_of_life')[0], 'The end of life date is not in the correct format');
	}

	/*
	 * Test the purchase cost provided is numeric
	 */
	public function test_purchase_cost_is_numeric()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'purchase_cost' => 'Fifty Thousand Pounds',
		]);
		$response->assertSessionHasErrors('purchase_cost');
		$this->assertEquals(session('errors')->get('purchase_cost')[0], 'The purchase cost must be a number');
	}

	/*
	 * Test the current value provided is numeric
	 */
	public function test_current_value_is_numeric()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'current_value' => 'Fifty Thousand Pounds',
		]);
		$response->assertSessionHasErrors('current_value');
		$this->assertEquals(session('errors')->get('current_value')[0], 'The current value must be a number');
	}

	/*
	 * Test the depreciation value provided is numeric
	 */
	public function test_depreciation_value_is_numeric()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'depreciation' => 'Fifty Thousand Pounds',
		]);
		$response->assertSessionHasErrors('depreciation');
		$this->assertEquals(session('errors')->get('depreciation')[0], 'The depreciation value must be a number');
	}


	/*
	 * Test the net book value value provided is numeric
	 */
	public function test_net_book_value_is_numeric()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'net_book_value' => 'Fifty Thousand Pounds',
		]);
		$response->assertSessionHasErrors('net_book_value');
		$this->assertEquals(session('errors')->get('net_book_value')[0], 'The net book value must be a number');
	}
}
