<?php

namespace Tests\Feature;

use App\Asset;
use App\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetControllerTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/*
	 * Test a guest user cannot view the schools assets view
	 */
	public function test_a_guest_cannot_view_all_schools_assets()
	{
		$school = factory(School::class)->create();
		$asset = factory(Asset::class)->create(['school_id' => $school->id]);
		$response = $this->get(route('schools.assets', ['id' => $asset->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest user cannot view an asset
	 */
	public function test_a_guest_cannot_view_assets()
	{
		$school = factory(School::class)->create();
		$asset = factory(Asset::class)->create(['school_id' => $school->id]);
		$response = $this->get(route('assets.show', ['id' => $asset->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot access the form to create assets
	 */
	public function test_a_guest_cannot_access_create_form_to_create_assets()
	{
		$response = $this->get(route('assets.create'));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot create new assets
	 */
	public function test_a_guest_cannot_create_new_assets()
	{
		$response = $this->post(route('assets.store'), [
			'name' => 'A New Asset',
			'tag' => $this->faker->randomNumber()
		]);
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot see the edit form for an asset
	 */
	public function test_a_guest_cannot_access_edit_form_to_update_assets()
	{
		$school = factory(School::class)->create();
		$asset = factory(Asset::class)->create(['school_id' => $school->id]);
		$response = $this->get(route('assets.edit', ['id' => $asset->id]));
		$response->assertRedirect(route('login'));
	}

	/*
	 * Test a guest cannot update existing assets
	 */
	public function test_a_guest_cannot_update_assets()
	{
		$school = factory(School::class)->create();
		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'name' => 'My Test Asset',
			'tag' => $this->faker->randomNumber()
		]);
		$response = $this->put(route('assets.update', ['id' => $asset->id]), [
			'name' => 'My Updated Test Asset'
		]);
		$response->assertRedirect(route('login'));
		$this->assertDatabaseMissing('assets', ['name' => 'My Updated Test Asset']);
	}

	/*
	 * Tests a guest cannot delete existing assets from storage
	 */
	public function test_a_guest_cannot_delete_assets()
	{
		$school = factory(School::class)->create();
		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'name' => 'My Test Asset',
			'tag' => $this->faker->randomNumber()
		]);
		$response = $this->delete(route('assets.update', ['id' => $asset->id]));
		$response->assertRedirect(route('login'));
		$this->assertDatabaseHas('assets', ['name' => 'My Test Asset']);
	}
}
