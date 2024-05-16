<?php

namespace IlBronza\TranslationsManager\Http\Controllers\CRUDTraits;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class MissingTranslationsShowParametersFile extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'base' => [
                'fields' => [
                    'language' => ['text' => 'string|required|max:255'],
                    'filename' => ['text' => 'string|required|max:255'],
                    'string' => ['text' => 'string|required|max:255'],
                    'variables' => ['select' => 'string|required|max:255'],
                    'prettyArgs' => ['select' => 'string|required|max:255']
                ],
            ],
            'data' => [
                'fields' => [
                    'prettyData' => [
                        'type' => 'textarea',
                        'displayMode' => 'show',
                        'rules' => []
                    ]
                ]
            ]
        ];
    }

}