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
            ['threshold' => $data['threshold']]
        );

        return response()->json(['ok' => true]);
    }
}
