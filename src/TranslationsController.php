<?php

// namespace IlBronza\TranslationsManager;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Config;
// use Illuminate\Support\Facades\Lang;
// use Illuminate\Support\Facades\Storage;

// class TranslationsController extends Controller
// {
// 	public function storeKey(Request $request, string $file, string $key)
// 	{
// 		$request->validate([
// 			'string' => 'required|string'
// 		]);

// 		$rootPath = base_path('/resources/lang/' . Config::get('app.locale'));
// 		$client = Storage::createLocalDriver(['root' => $rootPath]);

// 		if(! $client->exists($file . '.php'))
// 		{
// 			$client->put($file . '.php', []);
// 			$array = [];
// 		}
// 		else
// 			$array = Lang::get($file);

// 		$fileString = [];

// 			foreach($array as $_key => $value)
// 				$fileString[] = "	'" . $_key . "'" . " => " . "'" . $value . "'";

// 		$fileString[] = "	'" . $key . "'" . " => " . "'" . $request->string . "'";

// 		$fileText = "<?php

// return [
// " . implode(",\n", $fileString) . "
// ];
// 		";

// 		$rootPath = base_path('/resources/lang/' . Config::get('app.locale'));
// 		$client = Storage::createLocalDriver(['root' => $rootPath]);
// 		$client->put($file . '.php', $fileText);


//         if(! Storage::disk('local')->exists('translations.json'))
//             Storage::disk('local')->put('translations.json', json_encode([]));

//         $contents = Storage::disk('local')->get('translations.json');

//         $translations = json_decode($contents, true);

//         $jsonFileArray = $translations[$file];

// 		if (($arrayKey = array_search($key, $translations[$file] ?? [])) !== false)
// 			unset($translations[$file][$arrayKey]);

//         Storage::disk('local')->put('translations.json', json_encode($translations));

// 		return back();		
// 	}

// 	public function removeKey(string $file, string $key = null)
// 	{
//         if(! Storage::disk('local')->exists('translations.json'))
//             Storage::disk('local')->put('translations.json', json_encode([]));

//         $contents = Storage::disk('local')->get('translations.json');

//         $translations = json_decode($contents, true);

//         $jsonFileArray = $translations[$file];

// 		if (($arrayKey = array_search($key, $translations[$file] ?? [])) !== false)
// 			unset($translations[$file][$arrayKey]);

//         Storage::disk('local')->put('translations.json', json_encode($translations));

// 		return back();
// 	}
// }