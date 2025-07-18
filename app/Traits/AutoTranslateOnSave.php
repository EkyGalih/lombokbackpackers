<?php

namespace App\Traits;

use Stichoza\GoogleTranslate\GoogleTranslate;

trait AutoTranslateOnSave
{
    public static function bootAutoTranslateOnSave()
    {
        static::saving(function ($model) {
            if (! method_exists($model, 'getTranslatableAttributes')) {
                return;
            }

            $currentLocale = app()->getLocale();
            $targetLocale  = $currentLocale === 'en' ? 'id' : 'en';

            // helper closure
            $isHtml = fn(string $string): bool =>
                $string !== strip_tags($string);

            $translateHtml = function (string $html, string $from, string $to): string {
                $dom = new \DOMDocument();
                @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

                $xpath = new \DOMXPath($dom);

                foreach ($xpath->query('//text()') as $node) {
                    $text = trim($node->nodeValue);
                    if ($text !== '') {
                        $node->nodeValue = GoogleTranslate::trans($text, $to, $from);
                    }
                }

                $body = $dom->getElementsByTagName('body')->item(0);

                $innerHTML = '';
                foreach ($body->childNodes as $child) {
                    $innerHTML .= $dom->saveHTML($child);
                }

                return $innerHTML;
            };

            foreach ($model->getTranslatableAttributes() as $attr) {
                $value = $model->{$attr};

                // handle repeater-like (array of rows with translatable fields)
                if (is_array($value) && isset($value[0]) && is_array($value[0])) {
                    $current = [];
                    $target = [];

                    foreach ($value as $item) {
                        $val = $item['value'] ?? null;

                        $current[] = ['value' => $val];
                        $target[] = ['value' => GoogleTranslate::trans($val, $targetLocale, $currentLocale)];
                    }

                    $model->setTranslations($attr, [
                        $currentLocale => $current,
                        $targetLocale => $target,
                    ]);

                    continue;
                }

                // kalau string biasa
                if (! is_array($value) && ! is_null($value)) {
                    if ($isHtml($value)) {
                        $translated = $translateHtml($value, $currentLocale, $targetLocale);
                    } else {
                        $translated = GoogleTranslate::trans($value, $targetLocale, $currentLocale);
                    }

                    $model->setTranslations($attr, [
                        $currentLocale => $value,
                        $targetLocale  => $translated,
                    ]);
                }
            }
        });
    }
}
