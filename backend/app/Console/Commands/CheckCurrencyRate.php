<?php

namespace App\Console\Commands;

use App\Models\CurrencyAlert;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckCurrencyRate extends Command
{
    protected $signature = 'currency:check';
    protected $description = 'Check USD rate and send email if threshold reached';

    public function handle(): int
    {
        $alert = CurrencyAlert::first();

        if (!$alert || !$alert->email) {
            $this->warn('Alert not configured');
            return 0;
        }

        $response = Http::get('https://api.nbrb.by/exrates/rates/431');

        if (!$response->successful()) {
            $this->error('Failed to fetch rate');
            return 1;
        }

        $rate = $response->json()['Cur_OfficialRate'];

        if ($rate >= $alert->threshold) {
            $today = now()->toDateString();

            if ($alert->last_sent_at?->toDateString() === $today) {
                $this->info('Already sent today');
                return 0;
            }

            $text = "📈 Курс {$alert->currency}: {$rate} BYN\n📊 Порог: {$alert->threshold} BYN\n📅 Дата: " . now()->format('d-m-Y H:i');

            $telegramResponse = Http::post('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage', [
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => $text,
            ]);

            if (!$telegramResponse->successful()) {
                $this->error('Telegram error: ' . $telegramResponse->body());
                return 1;
            }

            $alert->update(['last_sent_at' => now()]);

            $this->info("Notification sent to {$alert->email}");
        } else {
            $this->info("Rate {$rate} below threshold {$alert->threshold}");
        }

        return 0;
    }
}
