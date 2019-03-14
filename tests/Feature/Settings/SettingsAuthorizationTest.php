<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsAuthorizationTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test a guest cannot access the settings page
	 */
	public function test_a_guest_cannot_access_settings_view()
	{
		$response = $this->get(route('settings.index'));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a user with read only or contribute role cannot access settings page
	 */
	public function test_non_admin_user_cannot_access_settings_view()
	{
		$roleA = factory(Role::class)->create(['name' => 'Read Only']);
		$roleB = factory(Role::class)->create(['name' => 'Contributor']);
		$userA = factory(User::class)->create(['role_id' => $roleA->id]);
		$userB = factory(User::class)->create(['role_id' => $roleB->id]);

		$response = $this->actingAs($userA)->get(route('settings.index'));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');

		$response = $this->actingAs($userB)->get(route('settings.index'));
		$response->assertRedirect(route('home'));
		$response->assertSessionHas('alert.danger', 'You are not authorized to perform this action');
	}

	/*
	 * Test an administrator can access the settings page
	 */
	public function test_admin_users_can_access_settings_view()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$response = $this->actingAs($user)->get(route('settings.index'));
		$response->assertViewIs('settings');
	}
}
