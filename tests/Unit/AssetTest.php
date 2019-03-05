<?php

namespace Tests\Unit;

use App\Asset;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test an asset can be stored
	 */
	public function test_an_asset_can_be_stored()
	{
		$asset = factory(Asset::class)->create([
			'tag' => '13579',
			'name' => 'Test Asset',
		]);

		$this->assertDatabaseHas('assets', [
			'id' => $asset->id,
			'name' => 'Test Asset'
		]);
	}

	/*
	 * Test an existing asset can be updated
	 */
	public function test_an_asset_can_be_updated()
	{
		$asset = factory(Asset::class)->create([
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
		$asset = factory(Asset::class)->create([
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
