<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

use App\Chat;
class ChatEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $chat;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chat $chat)
    {
        //
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
         return ['channel-'.$this->sumId($this->chat->sender,$this->chat->receiver)];
    }

    public function broadcastAs()
    {
      return 'broadcast-'.$this->sumId($this->chat->sender,$this->chat->receiver);
    }

    public function broadcastWith(){
      return [
          'id'=>$this->chat->id,
          'sender'=>$this->chat->sender,
          'receiver'=>$this->chat->receiver,
          'message'=>$this->chat->message
         ];
  }

  public function sumId($id,$id2){
    return $id+$id2;
  }

    
}
