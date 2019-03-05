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
}
