<?php

namespace Tests\Unit;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test a category can be stored
	 */
	public function test_a_category_can_be_stored()
	{
		$category = factory(Category::class)->create([
			'name' => 'Desktop Computers'
		]);

		$this->assertDatabaseHas('categories', [
			'id' => $category->id,
			'name' => 'Desktop Computers'
		]);
	}

	/*
	 * Test a category can be updated
	 */
	public function test_a_category_can_be_updated()
	{
		$category = factory(Category::class)->create([
			'name' => 'Desktop Computers'
		]);

		$category->update([
			'name' => 'Desktop PCs'
		]);

		$this->assertDatabaseHas('categories', [
			'id' => $category->id,
			'name' => 'Desktop PCs'
		]);
	}

	/*
	 * Test a category can be destroyed
	 */
	public function test_a_category_can_be_destroyed()
	{
		$category = factory(Category::class)->create([
			'name' => 'Desktop Computers'
		]);

		$category->destroy($category->id);

		$this->assertDatabaseMissing('categories', [
			'id' => $category->id,
			'name' => 'Desktop PCs'
		]);
	}
}
