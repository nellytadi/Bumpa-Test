<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BadgeUnlocked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user;
    private string $badgeName;

    /**
     * Create a new event instance.
     */
    public function __construct($user, $badgeName) {
        $this->user = $user;
        $this->badgeName = $badgeName;
    }

    public function getUser() {
        return $this->user;
    }

}
