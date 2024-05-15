<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2018_05_07_131728_create_assets_table.php
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
        Schema::create('assets', function (Blueprint $table) {
            
            $table->id('id');
            $table->string('symbol', 30)->unique();
            $table->string('name', 150);
            $table->string('external_id', 100)->unique()->nullable();
            $table->tinyInteger('status');
            $table->string('logo', 100)->nullable();
            $table->decimal('price', 20, 8)->default(0);
            $table->decimal('change_abs', 20, 8)->default(0);
            $table->decimal('change_pct', 12, 2)->default(0);
            $table->bigInteger('supply')->default(0);
            $table->bigInteger('volume')->default(0);
            $table->bigInteger('market_cap')->default(0);
            $table->timestamps();
            
            $table->index('name');
            $table->index('status');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
