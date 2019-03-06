<?php

namespace App\Policies;

use App\School;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolPolicy
{
	use HandlesAuthorization;

	/*
	 * Determine whether the user can view the school
	 */
	public function view(User $user, School $school)
	{
		return $user->schools->contains($school->id);
	}
}
