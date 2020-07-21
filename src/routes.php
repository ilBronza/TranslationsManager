<?php

Route::get(config('translationsmanager.routePrefix') . '/transtest', function () {
    return \ilBronza\TranslationsManager\TranslationsController::tidy();
});

Route::get(config('translationsmanager.routePrefix') . '/remove-key/{file}/{key?}', '\ilBronza\TranslationsManager\TranslationsController@removeKey')->name('ilBronza.translations.removeKey');

Route::post(config('translationsmanager.routePrefix') . '/store-key/{file}/{key}', '\ilBronza\TranslationsManager\TranslationsController@storeKey');