<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyAlert extends Model
{
    const EMAIL = 'email';
    const CURRENCY = 'currency';
    const MAX_THRESHOLD = 'max_threshold';
    const MIN_THRESHOLD = 'min_threshold';
    const LAST_SENT_AT = 'last_sent_at';
    const TELEGRAM_BOT_TOKEN = 'telegram_bot_token';
    const TELEGRAM_CHAT_ID = 'telegram_chat_id';

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
