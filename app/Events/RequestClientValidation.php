<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Events\Log;
use App\Models\User;

class RequestClientValidation implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     * @var \App\Models\User
     */
    public $personne;
    public function __construct(User $personne)
    {

        $this->personne = $personne;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        $id = 13;
        return new Channel('App.client.' . $id);
        //channel-name
    }
    public function broadcastWith()
    {

        return [
            'personne' => $this->personne,
        ];
    }
}
