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
	 * Test accounting start date returns correct format
	 */
	public function test_accounting_start_date_is_returned_in_correct_format()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'accounting_start' => '2017-08-01'
		]);

		$this->assertEquals('2017-08-01', $finance->accounting_start);
	}

	/*
	 * Test accounting start year attribute returns the year
	 */
	public function test_accounting_start_year_returns_only_the_year()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'accounting_start' => '2047-12-07'
		]);

		$this->assertEquals('2047', $finance->accounting_start_year);
	}

	/*
	 * Test accounting end year attribute returns the year
	 */
	public function test_accounting_end_year_returns_only_the_year()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'accounting_end' => '2027-12-07'
		]);

		$this->assertEquals('2027', $finance->accounting_end_year);
	}

	/*
	 * Test accounting year attribute returns accounting start and end years
	 */
	public function test_accounting_year_returns_accounting_start_and_end_years()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'accounting_start' => '2018-12-07',
			'accounting_end' => '2019-12-07'
		]);

		$this->assertEquals('2018-2019', $finance->accounting_year);
	}

	/*
	 * Test accounting end date returns correct format
	 */
	public function test_accounting_end_date_is_returned_in_correct_format()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'accounting_end' => '2017-08-01'
		]);

		$this->assertEquals('2017-08-01', $finance->accounting_end);
	}

	/*
	 * Test purchase date is returned in the correct format
	 */
	public function test_purchase_date_is_returned_in_correct_format()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'purchase_date' => '2017-08-01'
		]);

		$this->assertEquals('2017-08-01', $finance->purchase_date);
	}

	/*
	 * Test end of life date is returned in the correct format
	 */
	public function test_end_of_life_date_is_returned_in_correct_format()
	{
		factory(School::class)->create();
		factory(Category::class)->create();
		factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create([
			'asset_id' => $asset->id,
			'end_of_life' => '2017-08-01'
		]);

		$this->assertEquals('2017-08-01', $finance->end_of_life);
	}

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
