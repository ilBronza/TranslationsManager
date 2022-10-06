<?php

namespace IlBronza\TranslationsManager\Models;

use Auth;
use Carbon\Carbon;
use IlBronza\CRUD\Traits\Model\CRUDModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Translation\FileLoader;

class Missingtranslation extends Model
{
	use CRUDModelTrait;

	protected $fillable = [
		'filename',
		'string',
		'variables',
		'language'
	];

	protected $dates = [
		'translated_at',
		'deleted_at'
	];

	protected $casts = [
		'data' => 'json',
		'args' => 'json'
	];

	static $deletingRelationships = [];

	static function getByParameters(array $parameters)
	{
		return cache()->remember(
			'translation' . Str::slug(json_encode($parameters)),
			36000,
			function() use($parameters)
			{
				return static::where($parameters)->first();
			}
		);
	}

	public function getVariablesString()
	{
		$pieces = json_decode($this->variables);

		return implode("<br />", $pieces);
	}

	public function scopeTranslated($query)
	{
		return $query->whereNotNull('translated_at');
	}

	public function scopeToTranslate($query)
	{
		return $query->whereNull('translated_at');
	}

	static function getBacktraceCallingFiles() : ? array
	{
		$backtrace = debug_backtrace();

		$result = [];

		foreach($backtrace as $_backtrace)
		{
			$result[] = $_backtrace;

			if($_backtrace['function'] == 'trans')
				return $result;

			if(($_backtrace['class'] ?? null) == 'IlBronza\TranslationsManager\TranslationsManager')
				return $result;
		}

		dd($backtrace);

		return null;
	}

	public static function boot()
    {
        parent::boot();

		static::updating(function($model)
		{
			$rootPath = base_path('/resources/lang/' . $model->language);
			$client = Storage::createLocalDriver(['root' => $rootPath]);

			$filename = $model->filename . '.php';

			if(! $client->exists($filename))
				$client->put($filename, "<?php\n\nreturn ".var_export([], true).';'.\PHP_EOL);

			app()->setLocale($model->language);
			$translations = \Lang::get($model->filename);

			if(is_string($translations))
				$translations = [];

			$translations[$model->string] = $model->translation;

			$client->put($filename, "<?php\n\nreturn ".var_export($translations, true).';'.\PHP_EOL);

			$model->user_id = Auth::id();
			$model->translated_at = Carbon::now();
		});

		static::creating(function($model)
		{
			$backtrace = static::getBacktraceCallingFiles();

			$file = end($backtrace);

			$model->data = $backtrace;
			$model->args = $file['args'];
			$model->file = $file['file'];
			$model->line = $file['line'];
			$model->method = $file['function'];
		});

		// static::created(function($model)
		// {
		// 	$rootPath = base_path('/resources/lang/' . $model->language);
		// 	$client = Storage::createLocalDriver(['root' => $rootPath]);

		// 	$filename = $model->filename . '.php';

		// 	if(! $client->exists($filename))
		// 		$client->put($filename, "<?php\n\nreturn ".var_export([], true).';'.\PHP_EOL);

		// 	app()->setLocale($model->language);

		// 	$translations = \Lang::get($model->filename);

		// 	if(is_string($translations))
		// 		$translations = [];

  //           // dd(debug_backtrace());

		// 	if($model->string)
		// 		$translations[$model->string] = $model->string;

		// 	$client->put($filename, "<?php\n\nreturn ".var_export($translations, true).';'.\PHP_EOL);

		// 	$model->user_id = Auth::id();
		// 	$model->translated_at = Carbon::now();
		// });
    }
}




