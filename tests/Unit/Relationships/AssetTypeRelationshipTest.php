<?php

namespace Tests\Unit;

use App\Asset;
use App\Category;
use App\School;
use App\Type;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetTypeRelationshipTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * An asset can belong to a type
	 */
	public function test_an_asset_can_belong_to_a_type()
	{
		factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create([
			'type_id' => $type->id
		]);

		$this->assertTrue($asset->type->exists());
		$this->assertDatabaseHas('assets', [
			'id' => $asset->id,
			'type_id' => $type->id
		]);
	}

	/*
	 * A type can have many assets
	 */
	public function test_a_type_can_have_many_assets()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		$type = factory(Type::class)->create();
		factory(Asset::class, 10)->create([
			'type_id' => $type->id
		]);

		$this->assertTrue($type->assets()->exists());
	}
}
