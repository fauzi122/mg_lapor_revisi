<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BphSyncNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $sessionId;
    public string $menu;

    /**
     * Create a new event instance.
     */
    public function __construct(string $message, string $sessionId, string $menu)
    {
        $this->message = $message;
        $this->sessionId = $sessionId;
        $this->menu = $menu;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        Log::info("events : {$this->sessionId}");
        return new PrivateChannel("jobs.session.{$this->sessionId}.{$this->menu}");
    }

    public function broadcastAs()
    {
        return 'JobSyncCompleted';
    }
}
