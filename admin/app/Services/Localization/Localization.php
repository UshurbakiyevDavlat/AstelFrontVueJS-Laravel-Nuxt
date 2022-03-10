<?php

namespace App\Services\Localization;

use App;
use Request;
use App\Services\Localization\Translator;

class Localization
{

    protected $translator;

    protected $config;
    protected $locales;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;

        $this->config = config('localization');
        $this->locales = is_string($this->config['locales']) ? config($this->config['locales']) : $this->config['locales'];
    }


    public function translate(...$args) : string
    {
        return $this->translator->translate(...$args);
    }

    public function findOrCreateTranslation(...$args)
    {
        return $this->translator->findOrCreateTranslation(...$args);
    }


    public function setLocale(string $locale = null)
    {
        if (!$locale) {
            $locale = Request::segment(2);
        }

        if ($this->validateLocale($locale)) {
            App::setLocale($locale);
        } else {
            return '';
        }

        return App::getLocale();
    }


    public function getLocales() : array
    {
        return $this->locales;
    }


    private function validateLocale(string $locale = null) : bool
    {
        return isset($this->locales[$locale]);
    }


    public function getTextDirection(string $locale = null) : string
    {
        if (!$locale) {
            $locale = App::getLocale();
        }
        return $this->isRtl($locale) ? 'rtl' : 'ltr';
    }


    public function isRtl(string $locale = null) : bool
    {
        if (!$locale) {
            $locale = App::getLocale();
        }
        return in_array($locale, $this->config['rtl_locales']);
    }

}
