<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN last_sent_at TYPE timestamp USING last_sent_at::timestamp');
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN last_sent_at DROP NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN last_sent_at TYPE date');
    }
};
