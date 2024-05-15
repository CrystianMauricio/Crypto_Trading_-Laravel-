<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2018_12_02_093228_create_competition_assets_table.php
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
        
        Schema::create('competition_assets', function (Blueprint $table) {
            
            $table->id('id');
            $table->unsignedBigInteger('competition_id');
            $table->unsignedBigInteger('asset_id');
            
            $table->foreign('competition_id')->references('id')->on('competitions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('assets')->onUpdate('cascade')->onDelete('cascade');
            
            $table->unique(['competition_id','asset_id']);
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('competition_assets');
    }
};
