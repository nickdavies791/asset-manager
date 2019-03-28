<?php

namespace Tests\Unit;

use App\Asset;
use App\Category;
use App\Finance;
use App\School;
use App\Type;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinanceAccessorsTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test purchase cost is returned in pence
	 */
	public function test_purchase_cost_is_returned_in_pence()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'purchase_cost' => 5425.93
		]);

		$this->assertEquals(5425.93, $finance->purchase_cost);
	}

	/*
	 * Test current value is returned in pence
	 */
	public function test_current_value_is_returned_in_pence()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'current_value' => 5425.93
		]);

		$this->assertEquals(5425.93, $finance->current_value);
	}

	/*
	 * Test depreciation is returned in pence
	 */
	public function test_depreciation_is_returned_in_pence()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'depreciation' => 5425.93
		]);

		$this->assertEquals(5425.93, $finance->depreciation);
	}

	/*
	 * Test net book value is returned in pence
	 */
	public function test_net_book_value_is_returned_in_pence()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'net_book_value' => 5425.93
		]);

		$this->assertEquals(5425.93, $finance->net_book_value);
	}
}
