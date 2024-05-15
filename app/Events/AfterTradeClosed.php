<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AfterTradeClosed.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Events;

use App\Models\Trade;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterTradeClosed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $trade;

    
    public function __construct(Trade $trade)
    {
        $this->trade = $trade;
    }

    public function trade() {
        return $this->trade;
    }

    public function user() {
        return $this->trade()->user;
    }

    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
