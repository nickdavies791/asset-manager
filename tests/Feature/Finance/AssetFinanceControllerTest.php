<?php

namespace Tests\Feature;

use App\Asset;
use App\Category;
use App\Finance;
use App\Role;
use App\School;
use App\Type;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetFinanceControllerTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/*
	 * A guest cannot see the create form
	 */
	public function test_a_guest_cannot_access_create_view_to_create_finance_records()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		factory(Finance::class)->create();

		$response = $this->get(route('finances.create', ['id' => $asset->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * A guest cannot create new finance records
	 */
	public function test_a_guest_cannot_create_finance_records()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();

		$response = $this->post(route('finances.store', ['id' => $asset->id]), [
			'asset_id' => $asset->id,
			'accounting_start' => '2017-01-01',
			'accounting_end' => '2018-01-01',
			'purchase_date' => '2017-01-01',
			'accounting_end' => '2020-01-01',
			'purchase_cost' => 5425.85,
			'current_value' => 5425.85,
			'depreciation' => 800.60,
			'net_book_value' => 3250.68
		]);
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test authorised users can create finance records
	 */
	public function test_authorised_user_can_create_finance_records()
	{
		$school = factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$role = factory(Role::class)->create(['name' => 'Contributor']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'asset_id' => $asset->id,
			'accounting_start' => '2017-01-01',
			'accounting_end' => '2018-01-01',
			'purchase_date' => '2017-01-01',
			'end_of_life' => '2020-01-01',
			'purchase_cost' => 5425.85,
			'current_value' => 5425.85,
			'depreciation' => 800.60,
			'net_book_value' => 3250.68
		]);
		$this->assertDatabaseHas('finances', [
			'accounting_start' => '2017-01-01',
			'accounting_end' => '2018-01-01',
			'purchase_date' => '2017-01-01',
			'end_of_life' => '2020-01-01',
			'purchase_cost' => 542585,
			'current_value' => 542585,
			'depreciation' => 80060,
			'net_book_value' => 325068
		]);
		$response->assertRedirect(route('assets.show', ['id' => $asset->id]));
		$response->assertSessionHas('alert.success', 'Finance created!');
	}

	/*
	 * Test unauthorised users cannot create new finance records
	 */
	public function test_unauthorised_users_cannot_create_finance_records()
	{
		$school = factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$role = factory(Role::class)->create(['name' => 'Read Only']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$asset = factory(Asset::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('finances.store', ['id' => $asset->id]), [
			'asset_id' => $asset->id,
			'accounting_start' => '2017-01-01',
			'accounting_end' => '2018-01-01',
			'purchase_date' => '2017-01-01',
			'end_of_life' => '2020-01-01',
			'purchase_cost' => 5425.85,
			'current_value' => 5425.85,
			'depreciation' => 800.60,
			'net_book_value' => 3250.68
		]);
		$this->assertDatabaseMissing('finances', [
			'accounting_start' => '2017-01-01',
			'accounting_end' => '2018-01-01',
			'purchase_date' => '2017-01-01',
			'end_of_life' => '2020-01-01',
			'purchase_cost' => 542585,
			'current_value' => 542585,
			'depreciation' => 80060,
			'net_book_value' => 325068
		]);
		$response->assertRedirect(route('home'));
	}
}
