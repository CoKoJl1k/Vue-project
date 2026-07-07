<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('currency_alerts', function (Blueprint $table) {
            $table->renameColumn('threshold', 'max_threshold');
        });
    }

    public function down(): void
    {
        Schema::table('currency_alerts', function (Blueprint $table) {
            $table->renameColumn('max_threshold', 'threshold');
        });
    }
};
