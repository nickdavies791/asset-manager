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
}
