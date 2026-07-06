<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'currency' => 'required|string|size:3',
            'threshold' => 'required|numeric|min:0.01|max:999999.99',
            'telegram_bot_token' => 'required|string',
            'telegram_chat_id' => 'required|string',
        ];
    }
}
