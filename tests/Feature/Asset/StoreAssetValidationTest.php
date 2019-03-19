<?php

namespace Tests\Feature;

use App\Asset;
use App\Category;
use App\Role;
use App\School;
use App\Type;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAssetValidationTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/*
	 * Tests a school field is required when storing an asset
	 */
	public function test_school_id_is_required()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('assets.store'), [
			'tag' => $this->faker->numberBetween(0, 1000),
			'name' => $this->faker->word,
		]);
		$response->assertSessionHasErrors('school_id');
		$this->assertEquals(session('errors')->get('school_id')[0], 'Please choose a school');
	}

	/*
	 * Test the school provided exists in the database
	 */
	public function test_school_id_exists_in_database()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create(['id' => 1]);
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('assets.store'), [
			'school_id' => 985,
			'tag' => $this->faker->numberBetween(0, 1000),
			'name' => $this->faker->word,
		]);
		$response->assertSessionHasErrors('school_id');
		$this->assertEquals(session('errors')->get('school_id')[0], 'The school provided does not exist');
	}

	/*
	 * Test asset tag provided is required
	 */
	public function test_tag_is_required()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('assets.store'), [
			'school' => $school->id,
			'name' => $this->faker->word,
		]);
		$response->assertSessionHasErrors('tag');
		$this->assertEquals(session('errors')->get('tag')[0], 'Please provide an asset tag for this asset');
	}

	/*
	 * Test asset tag is unique for the given school
	 */
	public function test_tag_is_unique_for_given_school()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$user->schools()->attach($school->id);

		factory(Asset::class)->create(['school_id' => $school->id, 'tag' => '12345']);

		$response = $this->actingAs($user)->post(route('assets.store'), [
			'school_id' => $school->id,
			'category_id' => $category->id,
			'type_id' => $type->id,
			'tag' => '12345',
			'name' => 'My Test Asset'
		]);
		$response->assertSessionHasErrors('tag');
		$this->assertEquals(session('errors')->get('tag')[0], 'This tag is taken by another asset. Please choose a unique tag');
	}

	/*
	 * Test name is required
	 */
	public function test_name_is_required()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('assets.store'), [
			'tag' => '123ABC'
		]);
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'Please give this asset a name');
	}
}