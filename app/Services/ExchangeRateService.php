<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    public function getUsdToIdr(): float
    {
        return Cache::remember('usd_to_idr', now()->addHours(12), function () {
            $response = Http::get('https://open.er-api.com/v6/latest/USD');

            if (! $response->ok() || $response->json('result') !== 'success') {
                throw new \Exception('Failed to fetch exchange rate');
            }

            $rates = $response->json('rates');

            return $rates['IDR'] ?? 16100; // fallback ke nilai rata-rata
        });
    }
}
