<?php

Route::get(config('TranslationsManager.routePrefix') . '/transtest', function () {
    return \ilBronza\TranslationsManager\TranslationController::tidy();
});