<?php

namespace ilBronza\TranslationsManager;

use App\Http\Controllers\Controller;

class TranslationsController extends Controller
{
	static function tidy()
	{
		$contents = Storage::disk('local')->get('translations.json');

		$translations = json_decode($contents, true);

        return view('ilBronza.TranslationsManager.translationsList', compact('translations'));
	}
}