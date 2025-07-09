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
                    $model->setTranslations($attr, [
                        $currentLocale => $value,
                        $targetLocale  => GoogleTranslate::trans($value, $targetLocale, $currentLocale),
                    ]);
                }
            }
        });
    }
}
