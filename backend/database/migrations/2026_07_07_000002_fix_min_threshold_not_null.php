<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN min_threshold SET DEFAULT 0');
        DB::statement('UPDATE currency_alerts SET min_threshold = 0 WHERE min_threshold IS NULL');
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN min_threshold SET NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN min_threshold DROP DEFAULT');
        DB::statement('ALTER TABLE currency_alerts ALTER COLUMN min_threshold DROP NOT NULL');
    }
};
