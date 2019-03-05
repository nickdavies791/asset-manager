<?php

namespace Tests\Unit;

use App\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
	use RefreshDatabase;

    /*
     * Test a new Role can be stored
     */
    public function test_a_role_can_be_stored()
    {
    	factory(Role::class)->create([
    		'name' => 'Test Role'
		]);

    	$this->assertDatabaseHas('roles', [
    		'name' => 'Test Role'
		]);
    }

    /*
     * Test an existing role can be updated
     */
    public function test_a_role_can_be_updated()
	{
		$role = factory(Role::class)->create([
			'name' => 'Test Role'
		]);

		$role->update([
			'name' => 'Test Role Updated'
		]);

		$this->assertDatabaseHas('roles', [
			'id' => $role->id,
			'name' => 'Test Role Updated'
		]);
	}
}
