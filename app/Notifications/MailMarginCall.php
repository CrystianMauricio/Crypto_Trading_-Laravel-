<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   MailMarginCall.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Notifications;

use App\Models\Competition;
use App\Models\Trade;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailMarginCall extends Notification
{
    use Queueable;

    private $competition;
    private $trade;

    
    public function __construct(Competition $competition, Trade $trade)
    {
        $this->competition = $competition;
        $this->trade = $trade;
    }

    
    public function via($notifiable)
    {
        return ['mail'];
    }

    
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(__('app.margin_call'))
                    ->line(__('app.margin_call_text1', [
                        'name'      => $this->competition->title,
                        'level'     => $this->competition->min_margin_level,
                        'op'        => __('app.trade_direction_' . $this->trade->direction),
                        'qty'       => $this->trade->volume,
                        'symbol'    => $this->trade->asset->symbol,
                        'price'     => $this->trade->price_open,
                        'date'      => $this->trade->created_at,
                    ]));
    }

    
    public function toArray($notifiable)
    {
        return [
            
        ];
    }
}
