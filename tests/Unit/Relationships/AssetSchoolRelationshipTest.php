<?php

namespace Tests\Feature;

use App\Asset;
use App\Category;
use App\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetSchoolRelationshipTest extends TestCase
{
	use RefreshDatabase;

    /*
     * An asset can belong to a school
     */
    public function test_an_asset_can_belong_to_a_school()
	{
		factory(Category::class)->create();
		$school = factory(School::class)->create();
		$asset = factory(Asset::class)->create([
			'school_id' => $school->id,
		]);

		$this->assertTrue($asset->school->exists());
		$this->assertDatabaseHas('assets', [
			'id' => $asset->id,
			'school_id' => $school->id,
		]);
	}

    /*
     * A school can have many assets
     */
	public function test_a_school_can_have_many_assets()
	{
		factory(Category::class)->create();
		$school = factory(School::class)->create();
		factory(Asset::class, 10)->create(['school_id' => $school->id]);

		$this->assertTrue($school->assets()->exists());
	}
}
