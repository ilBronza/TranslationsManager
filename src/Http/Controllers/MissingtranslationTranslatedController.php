<?php

namespace IlBronza\TranslationsManager\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\TranslationsManager\Http\Controllers\CRUDTraits\CRUDMissingtranslationParametersTrait;
use IlBronza\TranslationsManager\Models\Missingtranslation;
use Illuminate\Http\Request;

class MissingtranslationTranslatedController extends CRUD
{
    use CRUDMissingtranslationParametersTrait;

    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    /**
     * subject model class full path
     **/
    public $modelClass = Missingtranslation::class;

    /**
     * http methods allowed. remove non existing methods to get a 403
     **/
    public $allowedMethods = [
        'index',
    ];

    public $indexFieldsGroups = ['index', 'translated'];

    public function getIndexElements()
    {
        return Missingtranslation::translated()->get();
    }
}

