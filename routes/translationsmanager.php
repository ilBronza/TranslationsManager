<?php

use IlBronza\TranslationsManager\Http\Controllers\ResetTranslationsDBController;
use IlBronza\TranslationsManager\TranslationsMenuManager;

Route::group([
	'middleware' => ['web', 'auth', 'role:administrator|superadmin'],
	'prefix' => 'translations-management',
	'routeTranslationPrefix' => TranslationsMenuManager::getRouteTranslationPrefix(),
	'namespace' => 'IlBronza\TranslationsManager\Http\Controllers'
	],
	function()
	{
		Route::get('reset-translations-db', [ResetTranslationsDBController::class, 'execute'])->name('missingtranslations.resetDB');

		Route::get('translated', 'MissingtranslationTranslatedController@index')->name('missingtranslations.translated');

		Route::resource('missingtranslations', 'MissingtranslationController')->names('missingtranslations');
	});
