<?php

namespace IlBronza\TranslationsManager\Http\Controllers;

use App\Http\Controllers\Controller;
use IlBronza\TranslationsManager\Models\Missingtranslation;

class ResetTranslationsDBController extends Controller
{
	public function execute()
	{
		Missingtranslation::truncate();

		return redirect()->route('missingtranslations.index');
	}
}

