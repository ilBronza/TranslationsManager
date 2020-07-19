<?php

namespace ilBronza\TranslationsManager;

use Illuminate\Support\Facades\Storage;
use Illuminate\Translation\Translator;

class TranslationsManager extends Translator
{
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $locale = $locale ?: $this->locale;

        // For JSON translations, there is only one file per locale, so we will simply load
        // that file and then we will be ready to check the array for the key. These are
        // only one level deep so we do not need to do any fancy searching through it.
        $this->load('*', '*', $locale);

        $line = $this->loaded['*']['*'][$locale][$key] ?? null;

        // If we can't find a translation for the JSON key, we will attempt to translate it
        // using the typical translation file. This way developers can always just use a
        // helper such as __ instead of having to pick between trans or __ with views.
        if (! isset($line))
        {
            [$namespace, $group, $item] = $this->parseKey($key);

            // Here we will get the locale that should be used for the language line. If one
            // was not passed, we will use the default locales which was given to us when
            // the translator was instantiated. Then, we can load the lines and return.
            $locales = $fallback ? $this->localeArray($locale) : [$locale];

            foreach ($locales as $locale)
                if (! is_null($line = $this->getLine(
                    $namespace, $group, $locale, $item, $replace
                    )))
                    break;
        }

        if($line)
            return $line;

        if(! Storage::disk('local')->exists('translations.json'))
            Storage::disk('local')->put('translations.json', json_encode([]));

        $contents = Storage::disk('local')->get('translations.json');

        $translations = json_decode($contents, true);

        $pieces = explode(".", $key);
        $filename = array_shift($pieces);

        if(! isset($translations[$filename]))
            $translations[$filename] = [];

        $string = implode(".", $pieces);

        if(! in_array($string, $translations[$filename]))
            $translations[$filename][] = $string;

        Storage::disk('local')->put('translations.json', json_encode($translations));

        return $key;

        // If the line doesn't exist, we will return back the key which was requested as
        // that will be quick to spot in the UI if language keys are wrong or missing
        // from the application's language files. Otherwise we can return the line.
        return $this->makeReplacements($line ?: $key, $replace);
    }
}