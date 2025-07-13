<?php

namespace App\Traits;

use App\Services\ExchangeRateService;
use Illuminate\Support\Facades\App;

trait FormatCurrency
{
    protected $symbols = [
        'IDR' => 'Rp',
        'USD' => '$',
        'EUR' => '€',
    ];

    /**
     * Format angka dengan auto locale-aware
     *
     * @param int|float|null $number
     * @param int $precision
     * @return string
     */
    public function formatCurrency(?int $number, int $precision = 1): string
    {
        if ($number === null) {
            return '0';
        }

        // deteksi locale
        $locale = App::getLocale();
        if (!in_array($locale, ['id', 'en'])) {
            $locale = 'id';
        }

        $from = 'IDR';

        if ($locale === 'id') {
            $to = 'IDR';
            $lang = 'id';
            $converted = $number;
        } else {
            $to = 'USD';
            $lang = 'en';

            // ambil kurs dinamis
            $service = app(ExchangeRateService::class);
            $rate = $service->getUsdToIdr();
            $converted = $number / $rate;
        }

        $suffixes = [
            'id' => [
                12 => 'T',
                9  => 'M',
                6  => 'jt',
                3  => 'k',
            ],
            'en' => [
                12 => 'T',
                9  => 'B',
                6  => 'M',
                3  => 'k',
            ],
        ];

        foreach ($suffixes[$lang] as $power => $suffix) {
            if ($converted >= pow(10, $power)) {
                $value = $converted / pow(10, $power);

                $formatted = (floor($value) == $value)
                    ? number_format($value, 0, ',', '')
                    : number_format($value, $precision, ',', '');

                return $this->symbols[$to] . ' ' . $formatted . $suffix;
            }
        }

        // fallback: tanpa suffix
        if ($to === 'IDR') {
            return $this->symbols[$to] . ' ' . number_format($converted, 0, ',', '.');
        } else {
            return $this->symbols[$to] . ' ' . number_format($converted, 2);
        }
    }
}
