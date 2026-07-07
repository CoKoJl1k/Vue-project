<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyAlert extends Model
{
    const string EMAIL = 'email';
    const string CURRENCY = 'currency';
    const string MAX_THRESHOLD = 'max_threshold';
    const string MIN_THRESHOLD = 'min_threshold';
    const string LAST_SENT_AT = 'last_sent_at';
    const string TELEGRAM_BOT_TOKEN = 'telegram_bot_token';
    const string TELEGRAM_CHAT_ID = 'telegram_chat_id';

    protected $fillable = [
        self::EMAIL,
        self::CURRENCY,
        self::MAX_THRESHOLD,
        self::MIN_THRESHOLD,
        self::LAST_SENT_AT,
        self::TELEGRAM_BOT_TOKEN,
        self::TELEGRAM_CHAT_ID,
    ];

    protected function casts(): array
    {
        return [
            self::MAX_THRESHOLD => 'decimal:2',
            self::MIN_THRESHOLD => 'decimal:2',
            self::LAST_SENT_AT => 'datetime',
        ];
    }
}
