<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyAlert extends Model
{
    protected $fillable = ['email', 'currency', 'threshold', 'last_sent_at'];

    protected function casts(): array
    {
        return [
            'threshold' => 'decimal:2',
            'last_sent_at' => 'date',
        ];
    }
}
