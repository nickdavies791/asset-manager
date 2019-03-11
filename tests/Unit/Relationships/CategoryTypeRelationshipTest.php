<?php

namespace Tests\Unit;

use App\Category;
use App\Type;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTypeRelationshipTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * A category can belong to many types
	 */
	public function test_a_category_can_belong_to_many_types()
	{
		$category = factory(Category::class)->create();
		$types = factory(Type::class, 5)->create();

		$category->types()->attach($types);

		$this->assertTrue($category->types()->exists());
	}

	/*
	 * A type can belong to many categories
	 */
	public function test_a_type_can_belong_to_many_categories()
	{
		$type = factory(Type::class)->create();
		$categories = factory(Category::class, 5)->create();

		$type->categories()->attach($categories);

		$this->assertTrue($type->categories()->exists());
	}
}
