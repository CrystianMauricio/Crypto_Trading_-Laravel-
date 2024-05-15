<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2018_05_20_131850_create_user_points_table.php
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
        Schema::create('user_points', function (Blueprint $table) {
            
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('type');
            $table->bigInteger('points');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('user_points');
    }
};
