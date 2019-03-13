<?php

namespace Tests\Feature;

use App\Role;
use App\Type;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeControllerTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test a guest user cannot see the create form to create types
	 */
	public function test_a_guest_cannot_access_create_form_to_create_types()
	{
		$response = $this->get(route('types.create'));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest user cannot create new asset types
	 */
	public function test_a_guest_cannot_create_types()
	{
		$response = $this->post(route('types.store'), [
			'name' => 'A New Asset Type',
		]);
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest user cannot see the edit form to update types
	 */
	public function test_a_guest_cannot_access_edit_form_to_update_types()
	{
		$type = factory(Type::class)->create();
		$response = $this->get(route('types.edit', ['id' => $type->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest user cannot update types
	 */
	public function test_a_guest_cannot_update_types()
	{
		$type = factory(Type::class)->create(['name' => 'A Test Asset Type']);
		$response = $this->put(route('types.update', ['id' => $type->id]), [
			'name' => 'A Test Updated Asset Type'
		]);
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest user cannot delete types
	 */
	public function test_a_guest_cannot_delete_types()
	{
		$type = factory(Type::class)->create(['name' => 'A Test Asset Type']);
		$response = $this->delete(route('types.destroy', ['id' => $type->id]));
		$response->assertRedirect(route('login'));
		$this->assertDatabaseHas('types', ['name' => 'A Test Asset Type']);
	}

	/*
	 * Test admin users can access create form to create types
	 */
	public function test_admin_users_can_access_create_form_to_create_types()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$response = $this->actingAs($user)->get(route('types.create'));
		$response->assertStatus(200);
		$response->assertViewIs('types.create');
	}

	/*
	 * Test non admin users cannot access the create form to create types
	 */
	public function test_non_admin_users_cannot_access_create_form_to_create_types()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$response = $this->actingAs($userA)->get(route('types.create'));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->get(route('types.create'));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test admin users can create types
	 */
	public function test_admin_users_can_create_types()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$response = $this->actingAs($user)->post(route('types.store'), ['name' => 'My Test Asset Type']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.success', 'Type created!');
	}

	/*
	 * Test non admin users cannot create new types
	 */
	public function test_non_admin_users_cannot_create_types()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$response = $this->actingAs($userA)->post(route('types.store'), ['name' => 'My First Asset Type']);
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->post(route('types.store'), ['name' => 'My Second Asset Type']);
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test admin users can access edit form to update types
	 */
	public function test_admin_users_can_access_edit_form_to_update_types()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$type = factory(Type::class)->create(['name' => 'My Test Asset Type']);

		$response = $this->actingAs($user)->get(route('types.edit', ['id' => $type->id]));
		$response->assertStatus(200);
		$response->assertViewIs('types.edit');
		$response->assertSee('My Test Asset Type');
	}

	/*
	 * Test non admin users cannot access edit form to update types
	 */
	public function test_non_admin_users_cannot_access_edit_form_to_update_categories()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);
		$type = factory(Type::class)->create(['name' => 'My Test Asset Type']);

		$response = $this->actingAs($userA)->get(route('types.edit', ['id' => $type->id]));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->get(route('types.edit', ['id' => $type->id]));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test admin users can update types
	 */
	public function test_admin_users_can_update_types()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$type = factory(Type::class)->create(['id' => 1, 'name' => 'Test Type']);

		$response = $this->actingAs($user)->put(route('types.update', ['id' => $type->id]), [
			'name' => 'An Updated Type'
		]);

		$this->assertDatabaseHas('types', ['name' => 'An Updated Type']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.success', 'Type updated!');
	}
	/*
	 * Test non admin users cannot update types
	 */
	public function test_non_admin_users_cannot_update_types()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);

		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$type = factory(Type::class)->create(['id' => 1, 'name' => 'Test Asset Type']);

		$response = $this->actingAs($userA)->put(route('types.update', ['id' => $type->id]), [
			'name' => 'An Updated Type'
		]);
		$this->assertDatabaseHas('types', ['name' => 'Test Asset Type']);
		$this->assertDatabaseMissing('types', ['name' => 'An Updated Type']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->put(route('types.update', ['id' => $type->id]), [
			'name' => 'An Updated Type'
		]);
		$this->assertDatabaseHas('types', ['name' => 'Test Asset Type']);
		$this->assertDatabaseMissing('types', ['name' => 'An Updated Type']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test admin users can delete types
	 */
	public function test_admin_users_can_delete_types()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$type = factory(Type::class)->create(['id' => 1, 'name' => 'Test Asset Type']);

		$response = $this->actingAs($user)->delete(route('types.destroy', ['id' => $type->id]));

		$this->assertDatabaseMissing('types', ['id' => 1, 'name' => 'Test Asset Type']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.success', 'Type deleted!');
	}

	/*
	 * Test non admin users cannot delete types
	 */
	public function test_non_admin_users_cannot_delete_types()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);

		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$type = factory(Type::class)->create(['id' => 1, 'name' => 'Test Asset Type']);

		$response = $this->actingAs($userA)->delete(route('types.destroy', ['id' => $type->id]));
		$this->assertDatabaseHas('types', ['name' => 'Test Asset Type']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->delete(route('types.destroy', ['id' => $type->id]));
		$this->assertDatabaseHas('types', ['name' => 'Test Asset Type']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}
}