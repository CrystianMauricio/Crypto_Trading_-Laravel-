<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   MailResetPasswordToken.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPasswordToken extends Notification
{
    use Queueable;

    private $token;

    
    public function __construct($token)
    {
        $this->token = $token;
    }

    
    public function via($notifiable)
    {
        return ['mail'];
    }

    
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line(__('auth.reset_email_text'))
            ->action(__('auth.reset'), sprintf('%s%s?email=%s', request()->getSchemeAndHttpHost(), route('password.reset', ['token' => $this->token], false), request()->email))
            ->line(__('auth.reset_email_text2'));
    }

    
    public function toArray($notifiable)
    {
        return [
            
        ];
    }
}
