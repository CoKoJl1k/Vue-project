<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyAlert extends Model
{
    protected $fillable = ['email', 'currency', 'max_threshold', 'min_threshold', 'last_sent_at', 'telegram_bot_token', 'telegram_chat_id'];

    protected function casts(): array
    {
        return [
            'max_threshold' => 'decimal:2',
            'min_threshold' => 'decimal:2',
            'last_sent_at' => 'date',
        ];
    }
}
