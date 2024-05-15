<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AfterCompetitionClosed.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Events;

use App\Models\Competition;
use App\Models\Trade;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterCompetitionClosed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $competition;

    
    public function __construct(Competition $competition)
    {
        $this->competition = $competition;
    }

    public function competition() {
        return $this->competition;
    }

    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
