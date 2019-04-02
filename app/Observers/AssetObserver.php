<?php

namespace App\Observers;

use App\Asset;
use App\Events\AssetCreated;

class AssetObserver
{
    /**
     * Handle the asset "created" event.
     *
     * @return void
     */
    public function created()
    {
        event(new AssetCreated(auth()->user()));
    }

    /**
     * Handle the asset "updated" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function updated(Asset $asset)
    {
        //
    }

    /**
     * Handle the asset "deleted" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function deleted(Asset $asset)
    {
        //
    }

    /**
     * Handle the asset "restored" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function restored(Asset $asset)
    {
        //
    }

    /**
     * Handle the asset "force deleted" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function forceDeleted(Asset $asset)
    {
        //
    }
}
