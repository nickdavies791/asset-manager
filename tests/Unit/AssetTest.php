<?php

namespace Tests\Unit;

use App\Asset;
use App\Category;
use App\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/*
	 * Test an asset can be stored
	 */
	public function test_an_asset_can_be_stored()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$asset = factory(Asset::class)->create();

		$this->assertDatabaseHas('assets', [
			'id' => $asset->id,
			'name' => $asset->name
		]);
	}

	/*
	 * Test an existing asset can be updated
	 */
	public function test_an_asset_can_be_updated()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'tag' => '13579',
			'name' => 'Test Asset'
		]);

		$asset->update([
			'tag' => '12345',
			'name' => 'Test Asset Updated'
		]);

		$this->assertDatabaseHas('assets', [
			'id' => $asset->id,
			'tag' => '12345',
			'name' => 'Test Asset Updated'
		]);
	}

	/*
	 * Test an existing asset can be destroyed
	 */
	public function test_an_asset_can_be_destroyed()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'tag' => '98765',
			'name' => 'Test Asset Deleted'
		]);

		$asset->destroy($asset->id);

		$this->assertDatabaseMissing('assets', [
			'id' => $asset->id,
			'tag' => '98765',
			'name' => 'Test Asset Deleted'
		]);
	}
}
