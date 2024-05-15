<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   2014_10_12_000000_create_users_table.php
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
        Schema::create('users', function (Blueprint $table) {
            
            $table->id('id');
            $table->string('name', 100)->unique();
            $table->string('email')->unique();
            $table->string('avatar', 100)->nullable();
            $table->string('role', 50);
            $table->tinyInteger('status');
            $table->string('password');
            $table->rememberToken();
            $table->dateTime('last_login_time')->nullable();
            $table->ipAddress('last_login_ip')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            
            $table->index('role');
            $table->index('status');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
