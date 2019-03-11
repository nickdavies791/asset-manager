<?php

namespace Tests\Unit;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleUserRelationshipTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * A role can have many users
	 */
	public function test_a_role_can_have_many_users()
	{
		$role = factory(Role::class)->create();
		factory(User::class, 100)->create(['role_id' => $role->id]);

		$this->assertTrue($role->users()->exists());
	}

	/*
	 * A user can belong to a role
	 */
	public function test_a_user_can_belong_to_a_role()
	{
		$role = factory(Role::class)->create();
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$this->assertTrue($user->role->exists());
	}
}
