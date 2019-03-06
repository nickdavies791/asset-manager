<?php

namespace App\Policies;

use App\School;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolPolicy
{
	use HandlesAuthorization;

	/*
	 * Determine whether the User can view the School
	 */
	public function view(User $user, School $school)
	{
		return $user->schools->contains($school->id);
	}

	/*
	 * Determine whether the User can create a School
	 */
	public function create(User $user)
	{
		return $user->isAdministrator();
	}
}
