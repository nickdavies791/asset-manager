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

class FinanceTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/*
	 * Test a finance record can be stored
	 */
	public function test_a_finance_record_can_be_stored()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create(['asset_id' => $asset->id]);

		$this->assertDatabaseHas('finances', [
			'id' => $finance->id,
			'asset_id' => $finance->asset_id
		]);
	}

	/*
	 * Test a finance record can be updated
	 */
	public function test_a_finance_record_can_be_updated()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create(['asset_id' => $asset->id]);

		$finance->update([
			'accounting_start' => '2018-01-01',
			'accounting_end' => '2019-01-01'
		]);

		$this->assertDatabaseHas('finances', [
			'id' => $finance->id,
			'asset_id' => $finance->asset_id,
			'accounting_start' => '2018-01-01',
			'accounting_end' => '2019-01-01'
		]);
	}

	/*
	 * Test a finance record can be destroyed
	 */
	public function test_a_finance_record_can_be_destroyed()
	{
		$school = factory(School::class)->create();
		$category = factory(Category::class)->create();
		$type = factory(Type::class)->create();
		$asset = factory(Asset::class)->create();
		$finance = factory(Finance::class)->create(['asset_id' => $asset->id]);

		$finance->destroy($finance->id);

		$this->assertDatabaseMissing('finances', [
			'id' => $finance->id,
			'asset_id' => $finance->asset_id,
		]);
	}
}
