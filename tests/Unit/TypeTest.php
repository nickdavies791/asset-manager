<?php

namespace Tests\Unit;

use App\Type;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test a type can be stored
	 */
	public function test_a_type_can_be_stored()
	{
		$type = factory(Type::class)->create([
			'name' => 'IT Equipment'
		]);

		$this->assertDatabaseHas('types', [
			'id' => $type->id,
			'name' => 'IT Equipment'
		]);
	}

	/*
	 * Test a type can be updated
	 */
	public function test_a_type_can_be_updated()
	{
		$type = factory(Type::class)->create([
			'name' => 'IT Equipment'
		]);

		$type->update([
			'name' => 'IT and Other Equipment'
		]);

		$this->assertDatabaseHas('types', [
			'id' => $type->id,
			'name' => 'IT and Other Equipment'
		]);
	}

	/*
	 * Test a type can be deleted
	 */
	public function test_a_type_can_be_destroyed()
	{
		$type = factory(Type::class)->create([
			'name' => 'IT Equipment'
		]);

		$type->destroy($type->id);

		$this->assertDatabaseMissing('types', [
			'id' => $type->id,
			'name' => 'IT Equipment'
		]);
	}
}
