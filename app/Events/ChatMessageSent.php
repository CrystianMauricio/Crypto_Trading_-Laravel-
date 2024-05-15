<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   ChatMessageSent.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    
    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    
    public function broadcastOn()
    {
        return new PresenceChannel('chat');
    }

    
    public function broadcastWith()
    {
        return [
            'message' => $this->message->message,
            'user' => [
                'id' => $this->message->user->id,
                'name' => $this->message->user->name
            ]
        ];
    }
}
