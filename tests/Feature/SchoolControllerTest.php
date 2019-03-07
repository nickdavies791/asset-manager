<?php

namespace Tests\Feature;

use App\Role;
use App\School;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolControllerTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test a guest user cannot view the schools index view
	 */
	public function test_a_guest_cannot_view_schools()
	{
		factory(School::class)->create(['name' => 'Test School']);
		$response = $this->get(route('schools.index'));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot access the create form to create new schools
	 */
	public function test_a_guest_cannot_access_create_form_to_create_new_schools()
	{
		$response = $this->get(route('schools.create'));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot post data to create new schools
	 */
	public function test_a_guest_cannot_create_new_schools()
	{
		$response = $this->post(route('schools.store'), [
			'name' => 'Test Guest School'
		]);
		$response->assertRedirect(route('login'));
		$this->assertDatabaseMissing('schools', ['name' => 'Test Guest School']);
	}

	/*
	 * Test guests cannot access the edit form and update schools
	 */
	public function test_a_guest_cannot_access_edit_form_to_update_schools()
	{
		$school = factory(School::class)->create(['name' => 'My Guest School']);

		$response = $this->get(route('schools.edit', ['id' => $school->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot update any existing schools
	 */
	public function test_a_guest_cannot_update_schools()
	{
		$school = factory(School::class)->create(['name' => 'My Guest School']);

		$response = $this->put(route('schools.update', ['id' => $school->id]), [
			'name' => 'My Updated Guest School'
		]);
		$response->assertRedirect(route('login'));
		$this->assertDatabaseMissing('schools', ['name' => 'My Updated Guest School']);
	}

	/*
	 * Test a guest cannot delete schools from storage
	 */
	public function test_a_guest_cannot_delete_schools()
	{
		$school = factory(School::class)->create(['name' => 'My Guest School']);

		$response = $this->delete(route('schools.destroy', ['id' => $school->id]));
		$response->assertRedirect(route('login'));
		$this->assertDatabaseHas('schools', ['name' => 'My Guest School']);
	}

	/*
	* Test a user can see the schools they are associated with
	*/
	public function test_a_user_can_see_all_schools_they_are_associated_with()
	{
		$role = factory(Role::class)->create();
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create(['name' => 'Test School User']);

		$user->schools()->attach($school);

		$response = $this->actingAs($user)->get(route('schools.index'));
		$response->assertViewIs('schools.index');
		$response->assertSeeText('Test School User');
	}

	/*
	 * Test a user can only see their own schools
	 */
	public function test_a_user_cannot_see_the_schools_they_are_not_associated_with()
	{
		$role = factory(Role::class)->create();
		$userA = factory(User::class)->create(['role_id' => $role->id]);
		$userB = factory(User::class)->create(['role_id' => $role->id]);
		$schoolA = factory(School::class)->create(['name' => 'Test School User A']);
		$schoolB = factory(School::class)->create(['name' => 'Test School User B']);

		$userA->schools()->attach($schoolA);
		$userB->schools()->attach($schoolB);

		$response = $this->actingAs($userA)->get(route('schools.index'));
		$response->assertViewIs('schools.index');
		$response->assertSeeText('Test School User A');
		$response->assertDontSeeText('Test School User B');

		$response = $this->actingAs($userB)->get(route('schools.index'));
		$response->assertViewIs('schools.index');
		$response->assertSeeText('Test School User B');
		$response->assertDontSeeText('Test School User A');
	}

	/*
	 * Test a user can only access the schools they are associated with
	 */
	public function test_a_user_can_access_the_schools_they_are_associated_with()
	{
		$role = factory(Role::class)->create();
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School ID 1']);
		$user->schools()->attach($school);

		$response = $this->actingAs($user)->get(route('schools.show', ['id' => 1]));
		$response->assertViewIs('schools.show');
		$response->assertSeeText('Test School ID 1');
	}

	/*
	 * Test a user cannot access the schools they are not associated with
	 */
	public function test_a_user_cannot_access_the_schools_they_are_not_associated_with()
	{
		$role = factory(Role::class)->create();
		$userA = factory(User::class)->create(['role_id' => $role->id]);
		$userB = factory(User::class)->create(['role_id' => $role->id]);
		$schoolA = factory(School::class)->create(['id' => 1, 'name' => 'Test School A']);
		$schoolB = factory(School::class)->create(['id' => 2, 'name' => 'Test School B']);

		$userA->schools()->attach($schoolA);
		$userB->schools()->attach($schoolB);

		$response = $this->actingAs($userA)->get(route('schools.show', ['id' => 1]));
		$response->assertViewIs('schools.show');
		$response->assertSeeText('Test School A');
		$response->assertDontSeeText('Test School B');
		$response = $this->actingAs($userA)->get(route('schools.show', ['id' => 2]));
		$response->assertSessionHas('alert.danger', 'You do not have access to this school');

		$response = $this->actingAs($userB)->get(route('schools.show', ['id' => 2]));
		$response->assertViewIs('schools.show');
		$response->assertSeeText('Test School B');
		$response->assertDontSeeText('Test School A');
		$response = $this->actingAs($userB)->get(route('schools.show', ['id' => 1]));
		$response->assertSessionHas('alert.danger', 'You do not have access to this school');
	}

	/*
	 * Test an admin user can access view to create new schools
	 */
	public function test_an_admin_user_can_access_create_form_to_create_new_schools()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$response = $this->actingAs($user)->get(route('schools.create'));

		$response->assertStatus(200);
		$response->assertViewIs('schools.create');
	}

	/*
	 * Test users without admin role cannot access the form to create new schools
	 */
	public function test_non_admin_users_cannot_access_create_form_to_create_new_schools()
	{
		$readonly = factory(Role::class)->create(['name' => 'Read Only']);
		$contributor = factory(Role::class)->create(['name' => 'Contributor']);
		$userA = factory(User::class)->create(['role_id' => $readonly->id]);
		$userB = factory(User::class)->create(['role_id' => $contributor->id]);

		$response = $this->actingAs($userA)->get(route('schools.create'));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You do not have access to create schools');

		$response = $this->actingAs($userB)->get(route('schools.create'));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You do not have access to create schools');
	}

	/*
	 * Test a user with the role 'Administrator' can create new schools
	 */
	public function test_an_admin_user_can_create_new_schools()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$response = $this->actingAs($user)->post(route('schools.store', [
			'name' => 'A New School'
		]));

		$this->assertDatabaseHas('schools', ['name' => 'A New School']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.success', 'School created!');
	}

	/*
	 * Tests that users without the 'Administrator' role cannot create new schools
	 */
	public function test_non_admin_users_cannot_create_new_schools()
	{
		$readonly = factory(Role::class)->create(['name' => 'Read Only']);
		$contributor = factory(Role::class)->create(['name' => 'Contributor']);

		$userA = factory(User::class)->create(['role_id' => $readonly->id]);
		$userB = factory(User::class)->create(['role_id' => $contributor->id]);

		$response = $this->actingAs($userA)->post(route('schools.store', ['name' => 'A New School']));
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You do not have access to create schools');

		$response = $this->actingAs($userB)->post(route('schools.store', ['name' => 'A New School']));
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You do not have access to create schools');
	}

	/*
	 * Test an admin user can view the edit form to update existing schools
	 */
	public function test_an_admin_user_can_access_edit_form_to_update_schools()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create(['name' => 'My Test School']);

		$response = $this->actingAs($user)->get(route('schools.edit', ['school' => $school->id]));

		$response->assertStatus(200);
		$response->assertViewIs('schools.edit');
		$response->assertSee('My Test School');
	}

	public function test_non_admin_users_cannot_access_edit_form_to_update_schools()
	{
		$readonly = factory(Role::class)->create(['name' => 'Read Only']);
		$contributor = factory(Role::class)->create(['name' => 'Contributor']);
		$userA = factory(User::class)->create(['role_id' => $readonly->id]);
		$userB = factory(User::class)->create(['role_id' => $contributor->id]);
		$school = factory(School::class)->create(['name' => 'My Test School']);

		$response = $this->actingAs($userA)->get(route('schools.edit', ['id' => $school->id]));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You do not have access to update schools');

		$response = $this->actingAs($userB)->get(route('schools.edit', ['id' => $school->id]));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You do not have access to update schools');
	}

	/*
	 * Tests an administrator can update existing schools
	 */
	public function test_an_admin_user_can_update_schools()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);

		$response = $this->actingAs($user)->put(route('schools.update', ['school' => $school->id]), [
			'name' => 'An Updated School Name'
		]);

		$this->assertDatabaseHas('schools', ['name' => 'An Updated School Name']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.success', 'School updated!');
	}

	/*
	 * Test non admins cannot update schools
	 */
	public function test_non_admin_users_cannot_update_schools()
	{
		$readonly = factory(Role::class)->create(['name' => 'Read Only']);
		$contributor = factory(Role::class)->create(['name' => 'Contributor']);

		$userA = factory(User::class)->create(['role_id' => $readonly->id]);
		$userB = factory(User::class)->create(['role_id' => $contributor->id]);

		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);

		$response = $this->actingAs($userA)->put(route('schools.update', ['school' => $school->id]), [
			'name' => 'An Updated School Name'
		]);

		$this->assertDatabaseHas('schools', ['name' => 'Test School']);
		$this->assertDatabaseMissing('schools', ['name' => 'An Updated School Name']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.danger', 'You do not have access to update schools');
	}

	/*
	 * Tests an administrator can delete schools
	 */
	public function test_an_admin_user_can_delete_schools()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create(['id' => 1, 'name' => 'Test School']);

		$response = $this->actingAs($user)->delete(route('schools.destroy', ['id' => $school->id]));

		$this->assertDatabaseMissing('schools', ['id' => 1, 'name' => 'Test School']);
		$response->assertStatus(302);
		$response->assertSessionHas('alert.success', 'School deleted!');
	}
}
