<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('currency_alerts', function (Blueprint $table) {
            $table->string('telegram_bot_token')->nullable(false)->change();
            $table->string('telegram_chat_id')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('currency_alerts', function (Blueprint $table) {
            $table->string('telegram_bot_token')->nullable()->change();
            $table->string('telegram_chat_id')->nullable()->change();
        });
    }
};
