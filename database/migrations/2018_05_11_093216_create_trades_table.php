<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2018_05_11_093216_create_trades_table.php
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
        Schema::create('trades', function (Blueprint $table) {
            
            $table->id('id');
            $table->unsignedBigInteger('competition_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('currency_id');
            $table->tinyInteger('direction');
            $table->integer('lot_size');
            $table->decimal('volume', 8, 2);
            $table->decimal('price_open', 20, 8);
            $table->decimal('price_close', 20, 8)->nullable();
            $table->decimal('margin', 10, 2);
            $table->decimal('pnl', 14, 2)->default(0);
            $table->tinyInteger('status');
            $table->timestamps();
            $table->dateTime('closed_at')->nullable();
            
            $table->foreign('competition_id')->references('id')->on('competitions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('assets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('cascade');
            
            $table->index('status');
            $table->index('pnl');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
