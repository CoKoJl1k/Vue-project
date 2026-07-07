<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("UPDATE currency_alerts SET telegram_bot_token = '' WHERE telegram_bot_token IS NULL");
        DB::statement("UPDATE currency_alerts SET telegram_chat_id = '' WHERE telegram_chat_id IS NULL");
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN telegram_bot_token SET NOT NULL');
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN telegram_chat_id SET NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN telegram_bot_token DROP NOT NULL');
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN telegram_chat_id DROP NOT NULL');
    }
};
