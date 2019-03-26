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

class AssetControllerTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/*
	 * Test a guest user cannot view the schools assets view
	 */
	public function test_a_guest_cannot_view_all_schools_assets()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create(['school_id' => $school->id]);
		$response = $this->get(route('schools.assets', ['id' => $school->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest user cannot view an asset
	 */
	public function test_a_guest_cannot_view_assets()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create(['school_id' => $school->id]);
		$response = $this->get(route('assets.show', ['id' => $asset->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot access the form to create assets
	 */
	public function test_a_guest_cannot_access_create_form_to_create_assets()
	{
		$response = $this->get(route('assets.create'));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot create new assets
	 */
	public function test_a_guest_cannot_create_new_assets()
	{
		$response = $this->post(route('assets.store'), [
			'name' => 'A New Asset',
			'tag' => $this->faker->randomNumber()
		]);
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot see the edit form for an asset
	 */
	public function test_a_guest_cannot_access_edit_form_to_update_assets()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create(['school_id' => $school->id]);
		$response = $this->get(route('assets.edit', ['id' => $asset->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot update existing assets
	 */
	public function test_a_guest_cannot_update_assets()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'name' => 'My Test Asset',
			'tag' => $this->faker->randomNumber()
		]);
		$response = $this->put(route('assets.update', ['id' => $asset->id]), [
			'name' => 'My Updated Test Asset'
		]);
		$response->assertRedirect(route('login'));
		$this->assertDatabaseMissing('assets', ['name' => 'My Updated Test Asset']);
	}

	/*
	 * Tests a guest cannot delete existing assets from storage
	 */
	public function test_a_guest_cannot_delete_assets()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'name' => 'My Test Asset',
			'tag' => $this->faker->randomNumber()
		]);
		$response = $this->delete(route('assets.update', ['id' => $asset->id]));
		$response->assertRedirect(route('login'));
		$this->assertDatabaseHas('assets', ['name' => 'My Test Asset']);
	}

	/*
	 * Test a guest user cannot view the schools assets view
	 */
	public function test_a_user_can_only_view_schools_assets_page_if_associated_with_the_school()
	{
		$schoolA = factory(School::class)->create(['id' => '1', 'name' => 'Test School A']);
		$schoolB = factory(School::class)->create(['id' => '2', 'name' => 'Test School B']);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		factory(Asset::class)->create(['school_id' => $schoolA->id, 'name' => 'Test Asset School A']);
		factory(Asset::class)->create(['school_id' => $schoolB->id, 'name' => 'Test Asset School B']);

		$role = factory(Role::class)->create(['name' => 'Read Only']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$user->schools()->attach($schoolA->id);

		$response = $this->actingAs($user)->get(route('schools.assets', ['id' => $schoolA->id]));
		$response->assertViewIs('schools.assets');
		$response->assertSee('Test Asset School A');
		$response = $this->actingAs($user)->get(route('schools.assets', ['id' => $schoolB->id]));
		$response->assertRedirect('home');
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test a user can only access an asset if they have access to that school
	 */
	public function test_a_user_can_only_view_assets_if_associated_with_that_school()
	{
		$schoolA = factory(School::class)->create(['id' => '1', 'name' => 'Test School A']);
		$schoolB = factory(School::class)->create(['id' => '2', 'name' => 'Test School B']);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$assetA = factory(Asset::class)->create(['school_id' => $schoolA->id, 'name' => 'Test Asset School A']);
		$assetB = factory(Asset::class)->create(['school_id' => $schoolB->id, 'name' => 'Test Asset School B']);

		$role = factory(Role::class)->create(['name' => 'Read Only']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$user->schools()->attach($schoolA->id);

		$response = $this->actingAs($user)->get(route('assets.show', ['id' => $assetA->id]));
		$response->assertViewIs('assets.show');
		$response->assertSee('Test Asset School A');
		$response = $this->actingAs($user)->get(route('assets.show', ['id' => $assetB->id]));
		$response->assertRedirect('home');
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test admins or contributors can access the form to create new assets
	 */
	public function test_a_user_can_access_create_form_if_has_contributor_or_admin_roles()
	{
		$roleA = factory(Role::class)->create(['name' => 'Contributor']);
		$roleB = factory(Role::class)->create(['name' => 'Administrator']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$response = $this->actingAs($userA)->get(route('assets.create'));
		$response->assertStatus(200);
		$response->assertViewIs('assets.create');

		$response = $this->actingAs($userB)->get(route('assets.create'));
		$response->assertStatus(200);
		$response->assertViewIs('assets.create');
	}

	/*
	 * Test users with read only role cannot access create new assets form
	 */
	public function test_a_user_cannot_access_create_form_if_has_read_only_role()
	{
		$role = factory(Role::class)->create(['name' => 'Read Only']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$response = $this->actingAs($user)->get(route('assets.create'));
		$response->assertRedirect('home');
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test a user can create assets if they are a contributor or admin
	 */
	public function test_a_user_can_create_assets_if_has_contributor_or_admin_roles()
	{
		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$roleA = factory(Role::class)->create(['name' => 'Contributor']);
		$roleB = factory(Role::class)->create(['name' => 'Administrator']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$userA->schools()->attach($school->id);
		$userB->schools()->attach($school->id);

		$asset = factory(Asset::class)->make();

		$response = $this->actingAs($userA)->post(route('assets.store'), [
			'school_id' => $asset->school_id,
			'category_id' => $asset->category_id,
			'type_id' => $asset->type_id,
			'name' => $asset->name,
			'tag' => 'ABC123',
			'asset_id' => $asset->id,
			'accounting_start' => '2019-01-01',
			'accounting_end' => '2020-01-01',
			'purchase_date' => '2019-05-05',
			'end_of_life' => '2022-05-05',
			'purchase_cost' => '5425.93',
			'current_value' => '5425.93',
			'depreciation' => '1790.56',
			'net_book_value' => '4921.80'
		]);

		$this->assertDatabaseHas('assets', ['tag' => 'ABC123']);
		$this->assertDatabaseHas('finances', ['net_book_value' => '4921.80']);
		$response->assertSessionHas('alert.success', 'Asset created!');

		$response = $this->actingAs($userB)->post(route('assets.store'), [
			'school_id' => $asset->school_id,
			'category_id' => $asset->category_id,
			'type_id' => $asset->type_id,
			'name' => $asset->name,
			'tag' => 'CBA123',
			'asset_id' => $asset->id,
			'accounting_start' => '2019-01-01',
			'accounting_end' => '2020-01-01',
			'purchase_date' => '2019-05-05',
			'end_of_life' => '2022-05-05',
			'purchase_cost' => '5425.93',
			'current_value' => '5425.93',
			'depreciation' => '1790.56',
			'net_book_value' => '4921.80'
		]);

		$this->assertDatabaseHas('assets', ['tag' => 'CBA123']);
		$this->assertDatabaseHas('finances', ['net_book_value' => '4921.80']);
		$response->assertSessionHas('alert.success', 'Asset created!');
	}

	/*
	 * Test users with read only role cannot create assets
	 */
	public function test_a_user_cannot_create_assets_if_has_read_only_role()
	{
		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$role = factory(Role::class)->create(['name' => 'Read Only']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('assets.store'), [
			'school_id' => $school->id,
			'category_id' => $category->id,
			'type_id' => $type->id,
			'name' => 'My Test Asset',
			'tag' => '13579'
		]);
		$this->assertDatabaseMissing('assets', ['name' => 'My Test Asset', 'tag' => '13579']);
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test a user with contributor or admin roles can see the assets edit form
	 */
	public function test_a_user_can_access_edit_form_if_contributor_or_admin()
	{
		$roleA = factory(Role::class)->create(['name' => 'Contributor']);
		$roleB = factory(Role::class)->create(['name' => 'Administrator']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create(['school_id' => $school->id]);

		$userA->schools()->attach($school->id);
		$userB->schools()->attach($school->id);

		$response = $this->actingAs($userA)->get(route('assets.edit', ['id' => $asset->id]));
		$response->assertStatus(200);
		$response->assertViewIs('assets.edit', ['id' => $asset->id]);

		$response = $this->actingAs($userB)->get(route('assets.edit', ['id' => $asset->id]));
		$response->assertStatus(200);
		$response->assertViewIs('assets.edit', ['id' => $asset->id]);
	}

	/*
	 * Test a read only user cannot access the edit form
	 */
	public function test_a_user_cannot_access_edit_form_if_read_only()
	{
		$role = factory(Role::class)->create(['name' => 'Read Only']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create(['school_id' => $school->id]);

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->get(route('assets.edit', ['id' => $asset->id]));
		$response->assertRedirect('home');
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test a user can update assets if authorised as contributor or admin
	 */
	public function test_a_user_can_update_assets_if_contributor_or_admin()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$roleA = factory(Role::class)->create(['name' => 'Contributor']);
		$roleB = factory(Role::class)->create(['name' => 'Administrator']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$assetA = factory(Asset::class)->create(['school_id' => $school->id, 'name' => 'My First Asset']);
		$assetB = factory(Asset::class)->create(['school_id' => $school->id, 'name' => 'My Second Asset']);

		$userA->schools()->attach($school->id);
		$userB->schools()->attach($school->id);
		$response = $this->actingAs($userA)->put(route('assets.update', ['id' => $assetA->id]), [
			'school_id' => $assetA->school_id,
			'category_id' => $assetA->category_id,
			'type_id' => $assetA->type_id,
			'tag' => $assetA->tag,
			'name' => 'My First Updated Asset',
		]);
		$this->assertDatabaseHas('assets', ['id' => $assetA->id, 'name' => 'My First Updated Asset']);
		$response->assertSessionHas('alert.success', 'Asset updated!');

		$response = $this->actingAs($userB)->put(route('assets.update', ['id' => $assetB->id]), [
			'school_id' => $assetB->school_id,
			'category_id' => $assetB->category_id,
			'type_id' => $assetB->type_id,
			'tag' => $assetB->tag,
			'name' => 'My Second Updated Asset',
		]);
		$this->assertDatabaseHas('assets', ['id' => $assetB->id, 'name' => 'My Second Updated Asset']);
		$response->assertSessionHas('alert.success', 'Asset updated!');
	}

	/*
	 * Test users with read only role cannot update assets
	 */
	public function test_a_user_cannot_update_assets_if_read_only()
	{
		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$role = factory(Role::class)->create(['name' => 'Read Only']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$asset = factory(Asset::class)->create(['school_id' => $school->id, 'name' => 'My First Asset']);

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->put(route('assets.update', ['id' => $asset->id]), [
			'school_id' => $school->id,
			'name' => 'My First Updated Asset',
			'tag' => '13579'
		]);
		$this->assertDatabaseMissing('assets', ['id' => $asset->id, 'name' => 'My First Updated Asset', 'tag' => '13579']);
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test users can delete assets if has admin role
	 */
	public function test_a_user_can_delete_assets_if_admin()
	{
		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$asset = factory(Asset::class)->create(['school_id' => $school->id, 'name' => 'My First Asset']);

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->delete(route('assets.update', ['id' => $asset->id]));
		$this->assertSoftDeleted($asset);
		$response->assertRedirect('home');
		$response->assertSessionHas('alert.success', 'Asset deleted!');
	}

	/*
	 * Test a user cannot delete an asset if they are not an administrator
	 */
	public function test_a_user_cannot_delete_assets_if_not_admin()
	{
		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$roleA = factory(Role::class)->create(['name' => 'Contributor']);
		$roleB = factory(Role::class)->create(['name' => 'Read Only']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);
		$asset = factory(Asset::class)->create(['school_id' => $school->id, 'name' => 'My First Asset']);

		$userA->schools()->attach($school->id);
		$userB->schools()->attach($school->id);

		$response = $this->actingAs($userA)->delete(route('assets.update', ['id' => $asset->id]));
		$this->assertDatabaseHas('assets', ['id' => $asset->id, 'name' => 'My First Asset']);
		$response->assertRedirect('home');
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->delete(route('assets.update', ['id' => $asset->id]));
		$this->assertDatabaseHas('assets', ['id' => $asset->id, 'name' => 'My First Asset']);
		$response->assertRedirect('home');
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}
}
