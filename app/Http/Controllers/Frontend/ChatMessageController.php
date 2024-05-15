<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   ChatMessageController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Frontend;

use App\Events\ChatMessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatMessageController extends Controller
{
    public function index()
    {
        return view('pages.frontend.chat.index');
    }

    public function getMessages()
    {
        $messages = ChatMessage::with('user:id,name')
            ->orderBy('created_at')
            ->limit(100)
            ->get();

        return [
            'messages' => $messages
        ];
    }

    public function sendMessage(Request $request)
    {
        $success = FALSE;

        if ($request->message) {
            $user = auth()->user();

            
            $message = new ChatMessage();
            $message->user()->associate($user);
            $message->message = $request->message;
            $message->save();

            broadcast(new ChatMessageSent($message))->toOthers();

            $success = TRUE;
        }

        return [
            'success' => $success
        ];
    }
}
