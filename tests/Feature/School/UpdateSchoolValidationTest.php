<?php

namespace Tests\Feature;

use App\Role;
use App\School;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateSchoolValidationTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/*
	 * Test the name field is required
	 */
	public function test_name_field_is_required()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();

		$response = $this->actingAs($user)->put(route('schools.update', ['id' => $school->id]));
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'Please enter a name for the school');
	}
}
