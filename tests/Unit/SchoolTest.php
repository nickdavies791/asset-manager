<?php

namespace Tests\Unit;

use App\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolTest extends TestCase
{
	use RefreshDatabase;

    /*
     * Test a new school can be stored
     */
    public function test_a_school_can_be_stored()
	{
		$school = factory(School::class)->create([
			'name' => 'Test School'
		]);

		$this->assertDatabaseHas('schools', [
			'id' => $school->id,
			'name' => 'Test School'
		]);
	}

	public function test_a_school_can_be_updated()
	{
		$school = factory(School::class)->create([
			'name' => 'Test School'
		]);

		$school->update([
			'name' => 'Test School Updated'
		]);

		$this->assertDatabaseHas('schools', [
			'id' => $school->id,
			'name' => 'Test School Updated'
		]);
	}
}
