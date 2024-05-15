<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2018_05_04_140111_create_competitions_participants_table.php
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
        Schema::create('competition_participants', function (Blueprint $table) {
            
            $table->id('id');
            $table->unsignedBigInteger('competition_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('start_balance', 12, 2);
            $table->decimal('current_balance', 12, 2);
            $table->integer('place')->nullable();
            $table->timestamps();
            
            $table->foreign('competition_id')->references('id')->on('competitions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            
            $table->unique(['competition_id','user_id']);
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('competition_participants');
    }
};
