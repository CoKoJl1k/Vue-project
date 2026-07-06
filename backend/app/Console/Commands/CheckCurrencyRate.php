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
        $response = Http::get('https://api.nbrb.by/exrates/rates/431');

        if (!$response->successful()) {
            $this->error('Failed to fetch rate');
            return 1;
        }

        $rate = $response->json()['Cur_OfficialRate'];

        $alerts = CurrencyAlert::all();

        if ($alerts->isEmpty()) {
            $this->warn('No alerts configured');
            return 0;
        }

        $today = now()->toDateString();
        $sent = 0;

        foreach ($alerts as $alert) {
            if ($rate < $alert->threshold) {
                $this->info("Rate {$rate} below {$alert->threshold} for {$alert->email}");
                continue;
            }

            if ($alert->last_sent_at?->toDateString() === $today) {
                $this->info("Already sent today to {$alert->email}");
                continue;
            }

            $text = "📈 Курс {$alert->currency}: {$rate} BYN\n📊 Порог: {$alert->threshold} BYN\n📅 Дата: " . now()->format('d-m-Y H:i') . "\n👤 Email: {$alert->email}";

            $telegramResponse = Http::post('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage', [
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => $text,
            ]);

            if (!$telegramResponse->successful()) {
                $this->error("Telegram error for {$alert->email}: " . $telegramResponse->body());
                continue;
            }

            $alert->update(['last_sent_at' => now()]);
            $sent++;
            $this->info("Sent to {$alert->email}");
        }

        $this->info("Done. Sent: {$sent}");
        return 0;
    }
}
