<?php

namespace IlBronza\TranslationsManager\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Http\Controllers\BasePackageController;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDDestroyTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\CRUD\Traits\CRUDUpdateEditorTrait;
use IlBronza\TranslationsManager\Http\Controllers\CRUDTraits\CRUDMissingtranslationParametersTrait;
use IlBronza\TranslationsManager\Http\Controllers\CRUDTraits\MissingTranslationsShowParametersFile;
use IlBronza\TranslationsManager\Models\Missingtranslation;
use Illuminate\Http\Request;

class MissingtranslationController extends BasePackageController
{
    static $packageConfigPrefix = 'translationsmanager';
    public $configModelClassName = 'missingtranslation';

    use CRUDMissingtranslationParametersTrait;

    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDShowTrait;
    use CRUDRelationshipTrait;
    use CRUDEditUpdateTrait;
    use CRUDUpdateEditorTrait;

    use CRUDDeleteTrait;
    use CRUDDestroyTrait;

    /**
     * subject model class full path
     **/

    public function setModelClass()
    {
        $this->modelClass = Missingtranslation::class;        
    }

    public $avoidCreateButton = true;

    /**
     * http methods allowed. remove non existing methods to get a 403
     **/
    public $allowedMethods = [
        'index',
        'show',
        'update',
        'destroy',
    ];

    public function getShowParametersFile()
    {
        return MissingTranslationsShowParametersFile::class;
    }

    public function getIndexElements()
    {
        return Missingtranslation::toTranslate()->application()->get();
    }

    public function show(Missingtranslation $missingtranslation)
    {
        return $this->_show($missingtranslation);
    }

    public function update(Request $request, Missingtranslation $missingtranslation)
    {
        return $this->_update($request, $missingtranslation);
    }

    public function destroy(Missingtranslation $missingtranslation)
    {
        return $this->_destroy($missingtranslation);
    }
}

