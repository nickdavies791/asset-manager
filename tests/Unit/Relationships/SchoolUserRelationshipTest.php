<?php

namespace Tests\Unit;

use App\Role;
use App\School;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolUserRelationshipTest extends TestCase
{
    use RefreshDatabase;

    /*
     * A school can belong to many users
     */
    public function test_a_school_can_belong_to_many_users()
	{
		$school = factory(School::class)->create();
		$role = factory(Role::class)->create();
		$users = factory(User::class, 100)->create(['role_id' => $role->id]);

		$school->users()->attach($users);

		$this->assertTrue($school->users()->exists());
	}

    /*
     * A user can belong to many schools
     */
    public function test_a_user_can_belong_to_many_schools()
	{
		$schools = factory(School::class, 100)->create();
		$role = factory(Role::class)->create();
		$user = factory(User::class)->create(['role_id' => $role->id]);

		$user->schools()->attach($schools);

		$this->assertTrue($user->schools()->exists());
	}
}
