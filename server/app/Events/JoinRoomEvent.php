<?php

namespace App\Events;

use App\Http\Resources\Quiz\RoomUserResource;
use App\Models\RoomUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JoinRoomEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public RoomUser $roomUser;
    
    public function __construct(RoomUser $roomUser)
    {
        $this->roomUser = $roomUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
            
            return new Channel('room.' . $this->roomUser->room_id);
    }

    public function broadcastAs()
    {
        return 'join-room';
    }

    public function broadcastWith()
    {
        return [
            'roomUser' => RoomUserResource::make($this->roomUser)
        ];
    }
}
