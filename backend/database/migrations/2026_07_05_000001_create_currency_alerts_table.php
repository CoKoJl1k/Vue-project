<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('currency', 10)->default('USD');
            $table->decimal('threshold', 8, 2);
            $table->date('last_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_alerts');
    }
};
