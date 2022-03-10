<?php

namespace App\Services\Localization;

use App\Services\Localization\Models\Translation;

use Cache;

class Translator
{

    public function translate(string $text, $replacement = []) : string
    {
        $hash = md5($text);
        if (Cache::has("translation.{$hash}")) {
            $translation = Cache::get("translation.{$hash}");
            $text = $translation[app()->getLocale()] ?? $translation['ru'];
        } else {
            $translation = $this->findOrCreateTranslation($text, $hash);
            $text = $translation->getTranslation('translation', \App::getLocale());
        }

        return str_replace(
            array_map(
                function($key) {
                    return "{{$key}}";
                },
                array_keys($replacement)
            ),
            array_values($replacement),
            $text
        );
    }

    public function findOrCreateTranslation(string $text, $hash = null) : Translation
    {
        if (!$hash) {
            $hash = md5($text);
        }

        $translation = Translation::where('hash', $hash)->first();

        if (!$translation) {
            $translation = new Translation;
            $translation->setTranslation('translation', 'ru', $text);
            $translation->save();
        }

        return $translation;
    }

}
