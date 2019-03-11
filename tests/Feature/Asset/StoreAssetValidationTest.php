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
	 * Test the school provided is an integer
	 */
	public function test_school_id_is_integer()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$response = $this->actingAs($user)->post(route('assets.store'), [
			'school_id' => $this->faker->word,
			'tag' => $this->faker->numberBetween(0, 1000),
			'name' => $this->faker->word,
		]);
		$response->assertSessionHasErrors('school_id');
		$this->assertEquals(session('errors')->get('school_id')[0], 'The school provided is not in the correct format');
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

		$asset = factory(Asset::class)->create(['school_id' => $school->id, 'tag' => '12345']);

		$response = $this->actingAs($user)->post(route('assets.store'), [
			'school' => $school->id,
			'tag' => '12345',
			'name' => $asset->name
		]);
		$response->assertSessionHasErrors('tag');
		$this->assertEquals(session('errors')->get('tag')[0], 'This tag is taken by another asset. Please choose a unique tag');
	}

	/*
	 * Test serial_number is a string
	 */
	public function test_serial_number_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'serial_number' => 1234567890
		]);

		$response = $this->actingAs($user)->post(route('assets.store'), $asset->toArray());
		$response->assertSessionHasErrors('serial_number');
		$this->assertEquals(session('errors')->get('serial_number')[0], 'The serial number provided is not in the correct format');
	}

	/*
	 * Test make is a string
	 */
	public function test_make_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'make' => 1234567890
		]);

		$response = $this->actingAs($user)->post(route('assets.store'), $asset->toArray());
		$response->assertSessionHasErrors('make');
		$this->assertEquals(session('errors')->get('make')[0], 'The make provided is not in the correct format');
	}

	/*
	 * Test model is a string
	 */
	public function test_model_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'model' => 1234567890
		]);

		$response = $this->actingAs($user)->post(route('assets.store'), $asset->toArray());
		$response->assertSessionHasErrors('model');
		$this->assertEquals(session('errors')->get('model')[0], 'The model provided is not in the correct format');
	}

	/*
	 * Test processor is a string
	 */
	public function test_processor_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'processor' => 1234567890
		]);

		$response = $this->actingAs($user)->post(route('assets.store'), $asset->toArray());
		$response->assertSessionHasErrors('processor');
		$this->assertEquals(session('errors')->get('processor')[0], 'The processor provided is not in the correct format');
	}

	/*
	 * Test memory is a string
	 */
	public function test_memory_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'memory' => 1234567890
		]);

		$response = $this->actingAs($user)->post(route('assets.store'), $asset->toArray());
		$response->assertSessionHasErrors('memory');
		$this->assertEquals(session('errors')->get('memory')[0], 'The memory provided is not in the correct format');
	}

	/*
	 * Test storage is a string
	 */
	public function test_storage_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'storage' => 1234567890
		]);

		$response = $this->actingAs($user)->post(route('assets.store'), $asset->toArray());
		$response->assertSessionHasErrors('storage');
		$this->assertEquals(session('errors')->get('storage')[0], 'The storage provided is not in the correct format');
	}

	/*
	 * Test operating_system is a string
	 */
	public function test_operating_system_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'operating_system' => 1234567890
		]);

		$response = $this->actingAs($user)->post(route('assets.store'), $asset->toArray());
		$response->assertSessionHasErrors('operating_system');
		$this->assertEquals(session('errors')->get('operating_system')[0], 'The operating system provided is not in the correct format');
	}

	/*
	 * Test warranty is a string
	 */
	public function test_warranty_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'warranty' => 1234567890
		]);

		$response = $this->actingAs($user)->post(route('assets.store'), $asset->toArray());
		$response->assertSessionHasErrors('warranty');
		$this->assertEquals(session('errors')->get('warranty')[0], 'The warranty provided is not in the correct format');
	}

	/*
	 * Test model is a string
	 */
	public function test_notes_is_string()
	{
		$role = factory(Role::class)->create(['name' => 'Administrator']);
		$user = factory(User::class)->create(['role_id' => $role->id]);
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();

		$user->schools()->attach($school->id);

		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'notes' => 1234567890
		]);

		$response = $this->actingAs($user)->post(route('assets.store'), $asset->toArray());
		$response->assertSessionHasErrors('notes');
		$this->assertEquals(session('errors')->get('notes')[0], 'Notes provided is not in the correct format');
	}
}
