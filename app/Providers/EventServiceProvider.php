<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   EventServiceProvider.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Events\ChatMessageSent;
use App\Listeners\BroadcastChatMessage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\AfterCompetitionClosed;
use App\Listeners\UserPointsEventsSubscriber;
use App\Listeners\CloneCompetitionIfRecurring;

class EventServiceProvider extends ServiceProvider
{
    
    protected $listen = [
        AfterCompetitionClosed::class => [ 
            CloneCompetitionIfRecurring::class 
        ],
        ChatMessageSent::class => [
            BroadcastChatMessage::class
        ]
    ];

    
    protected $subscribe = [
        UserPointsEventsSubscriber::class,
    ];

    
    public function boot(): void
    {
        
        if (config('settings.users.email_verification')) {
            Event::listen(Registered::class, SendEmailVerificationNotification::class);
        }
    }

    
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
