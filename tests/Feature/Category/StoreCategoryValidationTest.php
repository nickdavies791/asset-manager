<?php

namespace Tests\Feature;

use App\Category;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreCategoryValidationTest extends TestCase
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

		$response = $this->actingAs($user)->post(route('categories.store'));
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'Please enter a name for the category');
	}

	/*
	 * Test name field is of type string
	 */
	public function test_name_field_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$response = $this->actingAs($user)->post(route('categories.store'), ['name' => $this->faker->randomNumber()]);
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'The name field must be a string');
	}

	/*
	 * Test name field is unique
	 */
	public function test_name_field_is_unique()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		factory(Category::class)->create(['name' => 'Test Category']);

		$response = $this->actingAs($user)->post(route('categories.store'), ['name' => 'Test Category']);
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'A category with this name already exists');
	}
}
