<?php

namespace App\Events;

use App\Asset;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AssetCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The authenticated user.
     */
    public $user;

    /**
     * The requested asset.
     */
    public $asset;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Asset $asset
     */
    public function __construct(User $user, Asset $asset)
    {
        $this->user = $user;
        $this->asset = $asset;

        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('assets');
    }
}
