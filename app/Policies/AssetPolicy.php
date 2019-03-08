<?php

namespace App\Policies;

use App\User;
use App\Asset;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the asset.
     *
     * @param  \App\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function view(User $user, Asset $asset)
    {
        $school = $asset->school;

        if ($user->can('view', $school)) {
        	return $school->assets->contains($asset->id);
		}
    }

    /**
     * Determine whether the user can create assets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdministrator() || $user->isContributor();
    }

    /**
     * Determine whether the user can update the asset.
     *
     * @param  \App\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function update(User $user, Asset $asset)
    {
        $school = $asset->school;

        if ($user->can('view', $school) && ($user->isAdministrator() || $user->isContributor())) {
        	return $school->assets->contains($asset->id);
		}
    }

    /**
     * Determine whether the user can delete the asset.
     *
     * @param  \App\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function delete(User $user, Asset $asset)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can restore the asset.
     *
     * @param  \App\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function restore(User $user, Asset $asset)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the asset.
     *
     * @param  \App\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function forceDelete(User $user, Asset $asset)
    {
        //
    }
}
