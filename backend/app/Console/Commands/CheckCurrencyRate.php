<?php

namespace App\Console\Commands;

use App\Models\CurrencyAlert;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

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

            Mail::raw(
                "Курс {$alert->currency}: {$rate} BYN\nПорог: {$alert->threshold} BYN\nДата: " . now()->format('d-m-Y H:i'),
                fn ($msg) => $msg->to($alert->email)->subject("Курс {$alert->currency} достиг порога")
            );

            $alert->update(['last_sent_at' => now()]);

            $this->info("Notification sent to {$alert->email}");
        } else {
            $this->info("Rate {$rate} below threshold {$alert->threshold}");
        }

        return 0;
    }
}
