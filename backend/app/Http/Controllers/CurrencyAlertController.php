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
            ['telegram_chat_id' => $data['telegram_chat_id'], 'currency' => $data['currency']],
            [
                'threshold' => $data['threshold'],
                'telegram_bot_token' => $data['telegram_bot_token'],
                'telegram_chat_id' => $data['telegram_chat_id'],
                'email' => $data['telegram_chat_id'],
            ]
        );

        return response()->json(['ok' => true]);
    }
}
