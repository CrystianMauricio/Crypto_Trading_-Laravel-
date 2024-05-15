<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AfterUserJoinedCompetition.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Events;

use App\Models\Competition;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterUserJoinedCompetition
{
    private $competition;
    private $user;

    
    public function __construct(Competition $competition, User $user)
    {
        $this->competition = $competition;
        $this->user = $user;
    }

    public function competition() {
        return $this->competition;
    }

    public function user() {
        return $this->user;
    }

    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
