<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2018_04_26_105906_create_currencies_table.php
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
        Schema::create('currencies', function (Blueprint $table) {
            
            $table->id('id');
            $table->string('code', 3)->unique();
            $table->string('name')->unique();
            $table->string('symbol_native', 50);
            $table->decimal('rate', 12, 4)->default(0);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
