<?php

namespace IlBronza\TranslationsManager\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDDestroyTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDUpdateEditorTrait;
use IlBronza\TranslationsManager\Http\Controllers\CRUDTraits\CRUDMissingtranslationParametersTrait;
use IlBronza\TranslationsManager\Models\Missingtranslation;
use Illuminate\Http\Request;

class MissingtranslationController extends CRUD
{
    use CRUDMissingtranslationParametersTrait;

    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDEditUpdateTrait;
    use CRUDUpdateEditorTrait;

    use CRUDDeleteTrait;
    use CRUDDestroyTrait;
    /**
     * subject model class full path
     **/
    public $modelClass = Missingtranslation::class;

    public $avoidCreateButton = true;

    /**
     * http methods allowed. remove non existing methods to get a 403
     **/
    public $allowedMethods = [
        'index',
        'update',
        'destroy',
    ];

    public function getIndexElements()
    {
        return Missingtranslation::toTranslate()->application()->get();
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

