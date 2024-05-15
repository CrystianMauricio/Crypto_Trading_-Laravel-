<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2019_02_19_125624_create_chat_messages_table.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
