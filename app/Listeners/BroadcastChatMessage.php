<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   BroadcastChatMessage.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Listeners;

use App\Events\ChatMessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BroadcastChatMessage
{
    
    public function __construct()
    {
        
    }

    
    public function handle(ChatMessageSent $event)
    {
        
    }
}
