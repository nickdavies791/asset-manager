<?php

namespace Tests\Feature;

use App\Role;
use App\Type;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTypeValidationTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/*
	 * Test name field is required
	 */
	public function test_name_field_is_required()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$type = factory(Type::class)->create();

		$response = $this->actingAs($user)->put(route('types.update', ['id' => $type->id]));
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'Please enter a name for the asset type');
	}

	/*
	 * Test name field is of type string
	 */
	public function test_name_field_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$type = factory(Type::class)->create();

		$response = $this->actingAs($user)->put(route('types.update', ['id' => $type->id]), [
			'name' => $this->faker->randomNumber()
		]);
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'The name field must be a string');
	}
}
