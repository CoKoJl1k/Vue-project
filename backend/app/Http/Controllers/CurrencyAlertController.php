<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Models\CurrencyAlert;
use Illuminate\Http\JsonResponse;
class CurrencyAlertController extends Controller
{
    public function save(CurrencyRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['currency'] = strtoupper($data['currency']);

        CurrencyAlert::updateOrCreate(
            ['email' => $data['email'], 'currency' => $data['currency']],
            [
                'max_threshold' => $data['max_threshold'],
                'min_threshold' => $data['min_threshold'],
                'telegram_bot_token' => $data['telegram_bot_token'] ?? null,
                'telegram_chat_id' => $data['telegram_chat_id'] ?? null,
            ]
        );

        return response()->json(['ok' => true]);
    }
}
