<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   BeforeSettingsSaved.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class BeforeSettingsSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $request;

    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function request() {
        return $this->request;
    }

    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
