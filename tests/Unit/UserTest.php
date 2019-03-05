<?php

namespace Tests\Unit;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	use RefreshDatabase;

    /*
     * Test a new User can be stored
     */
    public function test_a_user_can_be_stored()
	{
		$role = factory(Role::class)->create();

		$user = factory(User::class)->create([
			'role_id' => $role->id,
			'name' => 'Test User',
			'email' => 'test_user@test.com'
		]);

		$this->assertDatabaseHas('users', [
			'id' => $user->id,
			'role_id' => $role->id,
			'name' => 'Test User',
			'email' => 'test_user@test.com'
		]);
	}

	/*
	 * Test an existing user can be updated
	 */
	public function test_a_user_can_be_updated()
	{
		$role = factory(Role::class)->create();

		$user = factory(User::class)->create([
			'role_id' => $role->id,
			'email' => 'test_user@test.com'
		]);

		$user->update([
			'email' => 'test_user_updated@test.com'
		]);

		$this->assertDatabaseHas('users', [
			'id' => $user->id,
			'role_id' => $role->id,
			'email' => 'test_user_updated@test.com'
		]);
	}
}
