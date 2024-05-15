<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2024_02_15_000000_alter_assets_table_drop_symbol_unique_index.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropUnique('assets_symbol_unique');

            $table->index('symbol');
        });
    }

    
    public function down(): void
    {
        
    }
};
