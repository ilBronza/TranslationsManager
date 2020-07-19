<?php

namespace ilBronza\TranslationsManager\Facades;

use Illuminate\Support\Facades\Facade;

class TranslationsManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'TranslationsManager';
    }
}
