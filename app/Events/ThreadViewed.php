<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadViewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Thread instance to use various functions/attributes of Thread.
     *
     * @var \App\Models\Thread
     */
    public $thread;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
