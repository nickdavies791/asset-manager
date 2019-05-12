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

class FinanceMutatorsTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test the purchase cost is saved in pence
	 */
	public function test_purchase_cost_is_saved_in_pence()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'purchase_cost' => 5425.93
		]);

		$this->assertDatabaseHas('finances', [
			'purchase_cost' => 542593
		]);
	}

	/*
	 * Test current value is saved in pence
	 */
	public function test_current_value_is_saved_in_pence()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'current_value' => 36358.90
		]);

		$this->assertDatabaseHas('finances', [
			'current_value' => 3635890
		]);
	}

	/*
	 * Test depreciation is saved in pence
	 */
	public function test_depreciation_is_saved_in_pence()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'depreciation' => 1052
		]);

		$this->assertDatabaseHas('finances', [
			'depreciation' => 105200
		]);
	}

	/*
	 * Test net book value is saved in pence
	 */
	public function test_net_book_value_is_saved_in_pence()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'net_book_value' => 30.12
		]);

		$this->assertDatabaseHas('finances', [
			'net_book_value' => 3012
		]);
	}
}
