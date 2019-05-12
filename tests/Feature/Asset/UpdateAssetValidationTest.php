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

class UpdateAssetValidationTest extends TestCase
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

		$asset = factory(Asset::class)->create();

		$response = $this->actingAs($user)->put(route('assets.update', ['id' => $asset->id]), [
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

		$asset = factory(Asset::class)->create();

		$response = $this->actingAs($user)->put(route('assets.update', ['id' => $asset->id]), [
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

		$asset = factory(Asset::class)->create();

		$response = $this->actingAs($user)->put(route('assets.update', ['id' => $asset->id]), [
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

		$assetA = factory(Asset::class)->create(['school_id' => $school->id, 'tag' => '12345']);
		$assetB = factory(Asset::class)->create(['school_id' => $school->id, 'tag' => '09876']);

		$response = $this->actingAs($user)->put(route('assets.update', ['id' => $assetA->id]), [
			'school_id' => $assetA->school_id,
			'category_id' => $assetA->category_id,
			'type_id' => $assetA->type_id,
			'tag' => '12345',
			'name' => 'Test Update Asset'
		]);
		$response->assertRedirect(route('assets.show', ['id' => $assetA->id]));
		$response->assertSessionHas('alert.success', 'Asset updated!');

		$response = $this->actingAs($user)->put(route('assets.update', ['id' => $assetA->id]), [
			'school_id' => $assetA->school_id,
			'category_id' => $assetA->category_id,
			'type_id' => $assetA->type_id,
			'tag' => '09876',
			'name' => 'Test Update Asset'
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

		$asset = factory(Asset::class)->create();

		$response = $this->actingAs($user)->put(route('assets.update', ['id' => $asset->id]), [
			'school_id' => $school->id,
		]);
		$response->assertSessionHasErrors('name');
		$this->assertEquals(session('errors')->get('name')[0], 'Please give this asset a name');
	}
}
