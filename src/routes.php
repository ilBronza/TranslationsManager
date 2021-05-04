<?php

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'translations-management',
	'namespace' => 'IlBronza\TranslationsManager\Http\Controllers'
	],
	function()
	{
		Route::get('translated', 'MissingtranslationTranslatedController@index')->name('missingtranslations.translated');
		Route::resource('missingtranslations', 'MissingtranslationController')->names('missingtranslations');
	});
