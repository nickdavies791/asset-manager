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
     *
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
}
