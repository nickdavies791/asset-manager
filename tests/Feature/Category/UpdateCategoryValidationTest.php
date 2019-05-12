<?php

namespace Tests\Feature;

use App\Category;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCategoryValidationTest extends TestCase
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
		$category = factory(Category::class)->create(['name' => 'Test Category']);

		$response = $this->actingAs($user)->put(route('categories.update', ['id' => $category->id]));
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'Please enter a name for the category');
	}

	/*
	 * Test name field is unique
	 */
	public function test_name_field_is_unique()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		factory(Category::class)->create(['name' => 'Building']);

		$category = factory(Category::class)->create(['name' => 'IT Equipment']);

		$response = $this->actingAs($user)->put(route('categories.update', ['id' => $category->id]), [
			'name' => 'Building'
		]);
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'A category with this name already exists');
	}
}
