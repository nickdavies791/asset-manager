<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test a guest cannot view the home page
	 */
	public function test_a_guest_cannot_view_home()
	{
		$response = $this->get(route('home'));
		$response->assertRedirect('/login');
	}

	/*
	 * Test a logged in user can view the home page
	 */
	public function test_a_user_can_view_home()
	{
		$role = factory(Role::class)->create();
		$user = factory(User::class)->create([
			'role_id' => $role->id
		]);
		$response = $this->actingAs($user)->get(route('home'));

		$response->assertViewIs('home');
	}
}
