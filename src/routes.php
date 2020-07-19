<?php

Route::get(config('translationsmanager.routePrefix') . '/transtest', function () {
    return \ilBronza\TranslationsManager\TranslationController::tidy();
});