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
            [CurrencyAlert::EMAIL => $data['email'], CurrencyAlert::CURRENCY => $data['currency']],
            [
                CurrencyAlert::MAX_THRESHOLD => $data['max_threshold'],
                CurrencyAlert::MIN_THRESHOLD => $data['min_threshold'],
                CurrencyAlert::TELEGRAM_BOT_TOKEN => $data['telegram_bot_token'] ?? null,
                CurrencyAlert::TELEGRAM_CHAT_ID => $data['telegram_chat_id'] ?? null,
            ]
        );

        return response()->json(['ok' => true]);
    }
}
