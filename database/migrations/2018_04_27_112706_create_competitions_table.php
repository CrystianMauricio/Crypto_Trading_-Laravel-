<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2018_04_27_112706_create_competitions_table.php
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
        Schema::create('competitions', function (Blueprint $table) {
            
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('currency_id');
            $table->string('title', 150);
            $table->string('duration', 30);
            $table->mediumInteger('slots_required')->unsigned();
            $table->mediumInteger('slots_taken')->unsigned()->default(0);
            $table->mediumInteger('slots_max')->unsigned();
            $table->decimal('start_balance', 12, 2);
            $table->integer('lot_size');
            $table->integer('leverage');
            $table->decimal('volume_min', 6, 2);
            $table->decimal('volume_max', 8, 2);
            $table->decimal('min_margin_level', 6, 2);
            $table->decimal('fee', 14, 2)->default(0);
            $table->text('payout_structure')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->tinyInteger('status');
            $table->boolean('recurring')->default(0);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('cascade');
            
            $table->index('status');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
