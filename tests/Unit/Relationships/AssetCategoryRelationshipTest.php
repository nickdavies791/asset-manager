<?php

namespace Tests\Feature;

use App\Asset;
use App\Category;
use App\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetCategoryRelationshipTest extends TestCase
{
	use RefreshDatabase;

    /*
     * An asset can belong to a category
     */
    public function test_an_asset_can_belong_to_a_category()
	{
		$category = factory(Category::class)->create();
		$school = factory(School::class)->create();
		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
			'category_id' => $category->id
		]);

		$this->assertTrue($asset->category->exists());
		$this->assertDatabaseHas('assets', [
			'id' => $asset->id,
			'school_id' => $school->id,
			'category_id' => $category->id
		]);
	}

    /*
     * A category can have many assets
     */
    public function test_a_category_can_have_many_assets()
	{
		$category = factory(Category::class)->create();
		factory(School::class)->create();
		factory(Asset::class, 10)->create(['category_id' => $category->id]);

		$this->assertTrue($category->assets()->exists());
	}
}
