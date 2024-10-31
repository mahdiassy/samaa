<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


use Illuminate\Queue\SerializesModels;

class MusicControlEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $action;
    public $track;

    /**
     * Create a new event instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct($data)
    {
        $this->action = $data['action'];
        $this->track = $data['track'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('music-control');
    }
}
