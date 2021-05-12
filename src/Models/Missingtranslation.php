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

	public $deletingRelationships = [];

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
    }
}




