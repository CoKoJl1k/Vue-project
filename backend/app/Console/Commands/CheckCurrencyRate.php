<?php

namespace App\Console\Commands;

use App\Models\CurrencyAlert;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckCurrencyRate extends Command
{
    protected $signature = 'currency:check';
    protected $description = 'Check USD rate and send telegram if thresholds reached';

    public function handle(): int
    {
        $response = Http::get('https://api.nbrb.by/exrates/rates/431');

        if (!$response->successful()) {
            $this->error('Failed to fetch rate');
            return 1;
        }
        $rate = $response->json()['Cur_OfficialRate'];

        $alerts = CurrencyAlert::query()
            ->whereNotNull('telegram_bot_token')
            ->whereNotNull('telegram_chat_id')
            ->get();

        if ($alerts->isEmpty()) {
            $this->warn('No alerts configured');
            return 0;
        }
        $sent = 0;
        foreach ($alerts as $alert) {
            if ($alert->last_sent_at && $alert->last_sent_at->isToday()) {
                $this->info("Already sent today to {$alert->email}");
                continue;
            }
            if ($rate >= $alert->max_threshold || $rate <= $alert->min_threshold) {
                $direction = $rate >= $alert->max_threshold ? 'max' : 'min';
                $label = $direction === 'max' ? '📈 Превышение' : '📉 Падение';
                $threshold = $direction === 'max' ? $alert->max_threshold : $alert->min_threshold;
                $text = "{$label}: {$alert->currency}\n"
                      . "Курс: {$rate} BYN\n"
                      . "Порог: {$threshold} BYN\n"
                      . "Дата: " . now()->format('d-m-Y H:i') . "\n"
                      . "Email: {$alert->email}";
            } else {
                $this->info("Rate {$rate} within thresholds for {$alert->email}");
                continue;
            }

            $telegramResponse = Http::post('https://api.telegram.org/bot' . $alert->telegram_bot_token . '/sendMessage', [
                'chat_id' => $alert->telegram_chat_id,
                'text' => $text,
            ]);

            if (!$telegramResponse->successful()) {
                $this->error("Telegram error for {$alert->email}: " . $telegramResponse->body());
                continue;
            }

            $alert->update([CurrencyAlert::LAST_SENT_AT => now()]);
            $sent++;
            $this->info("Sent alert to {$alert->email}");
        }

        $this->info("Done. Sent: {$sent}");
        return 0;
    }
}
