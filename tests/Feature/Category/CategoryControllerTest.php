<?php

namespace Tests\Feature;

use App\Category;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Test a guest user cannot see the create form to create categories
     */
    public function test_a_guest_cannot_access_create_form_to_create_categories()
	{
		$response = $this->get(route('categories.create'));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest user cannot create new categories
	 */
	public function test_a_guest_cannot_create_categories()
	{
		$response = $this->post(route('categories.store'), [
			'name' => 'A New Category',
		]);
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest user cannot see the edit form to update categories
	 */
	public function test_a_guest_cannot_access_edit_form_to_update_categories()
	{
		$category = factory(Category::class)->create();
		$response = $this->get(route('categories.edit', ['id' => $category->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest user cannot update categories
	 */
	public function test_a_guest_cannot_update_categories()
	{
		$category = factory(Category::class)->create(['name' => 'A Test Category']);
		$response = $this->put(route('categories.update', ['id' => $category->id]), [
			'name' => 'A Test Updated Category'
		]);
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot delete categories
	 */
	public function test_a_guest_cannot_delete_categories()
	{
		$category = factory(Category::class)->create(['name' => 'A Test Category']);
		$response = $this->delete(route('categories.destroy', ['id' => $category->id]));
		$response->assertRedirect(route('login'));
		$this->assertDatabaseHas('categories', ['name' => 'A Test Category']);
	}

	/*
	 * Test admin users can access the create form to create new categories
	 */
	public function test_admin_users_can_access_create_form_to_create_categories()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$response = $this->actingAs($user)->get(route('categories.create'));
		$response->assertStatus(200);
		$response->assertViewIs('categories.create');
	}

	/*
	 * Test a user cannot see the create form to create new categories
	 */
	public function test_non_admin_users_cannot_access_create_form_to_create_categories()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$response = $this->actingAs($userA)->get(route('categories.create'));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->get(route('categories.create'));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test admins can create new categories
	 */
	public function test_admin_users_can_create_categories()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$response = $this->actingAs($user)->post(route('categories.store'), ['name' => 'My Test Asset']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.success', 'Category created!');
	}

	/*
	 * Test non admin users cannot POST data to create categories
	 */
	public function test_non_admin_users_cannot_create_categories()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$response = $this->actingAs($userA)->post(route('categories.store'), ['name' => 'My First Category']);
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->post(route('categories.store'), ['name' => 'My Second Category']);
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test an admin can see the edit form to update a category
	 */
	public function test_an_admin_user_can_access_edit_form_to_update_categories()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$category = factory(Category::class)->create(['name' => 'My Test Category']);

		$response = $this->actingAs($user)->get(route('categories.edit', ['id' => $category->id]));
		$response->assertStatus(200);
		$response->assertViewIs('categories.edit');
		$response->assertSee('My Test Category');
	}

	public function test_non_admin_users_cannot_access_edit_form_to_update_categories()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);
		$category = factory(Category::class)->create(['name' => 'My Test Category']);

		$response = $this->actingAs($userA)->get(route('categories.edit', ['id' => $category->id]));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->get(route('categories.edit', ['id' => $category->id]));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test an admin user can update categories
	 */
	public function test_an_admin_user_can_update_categories()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$category = factory(Category::class)->create(['id' => 1, 'name' => 'Test Category']);

		$response = $this->actingAs($user)->put(route('categories.update', ['id' => $category->id]), [
			'name' => 'An Updated Category Name'
		]);

		$this->assertDatabaseHas('categories', ['name' => 'An Updated Category Name']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.success', 'Category updated!');
	}

	/*
	 * Test non admin users cannot update categories
	 */
	public function test_non_admin_users_cannot_update_categories()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);

		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$category = factory(Category::class)->create(['id' => 1, 'name' => 'Test Category']);

		$response = $this->actingAs($userA)->put(route('categories.update', ['id' => $category->id]), [
			'name' => 'An Updated Category Name'
		]);
		$this->assertDatabaseHas('categories', ['name' => 'Test Category']);
		$this->assertDatabaseMissing('categories', ['name' => 'An Updated Category Name']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->put(route('categories.update', ['id' => $category->id]), [
			'name' => 'An Updated Category Name'
		]);
		$this->assertDatabaseHas('categories', ['name' => 'Test Category']);
		$this->assertDatabaseMissing('categories', ['name' => 'An Updated Category Name']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test an admin user can delete categories
	 */
	public function test_an_admin_can_delete_categories()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$category = factory(Category::class)->create(['id' => 1, 'name' => 'Test Category']);

		$response = $this->actingAs($user)->delete(route('categories.destroy', ['id' => $category->id]));

		$this->assertDatabaseMissing('categories', ['id' => 1, 'name' => 'Test Category']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.success', 'Category deleted!');
	}

	/*
	 * Test non admin users cannot delete categories
	 */
	public function test_non_admin_users_cannot_delete_categories()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);

		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$category = factory(Category::class)->create(['id' => 1, 'name' => 'Test Category']);

		$response = $this->actingAs($userA)->delete(route('categories.destroy', ['id' => $category->id]));
		$this->assertDatabaseHas('categories', ['name' => 'Test Category']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->delete(route('categories.destroy', ['id' => $category->id]));
		$this->assertDatabaseHas('categories', ['name' => 'Test Category']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}
}
