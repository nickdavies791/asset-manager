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

	/*
	 * Test an existing school can be updated
	 */
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

	/*
	 * Test a school can be soft deleted
	 */
	public function test_a_school_can_be_soft_deleted()
	{
		$school = factory(School::class)->create([
			'name' => 'Test School Deleted'
		]);

		$school->destroy($school->id);

		$this->assertSoftDeleted($school);
	}

	/*
	 * Test a school can be permanently deleted
	 */
	public function test_a_school_can_be_permanently_deleted()
	{
		$school = factory(School::class)->create([
			'name' => 'Test School Deleted'
		]);

		$school->forceDelete($school->id);

		$this->assertDatabaseMissing('schools', [
			'id' => $school->id,
			'name' => 'Test School Deleted'
		]);
	}
}
