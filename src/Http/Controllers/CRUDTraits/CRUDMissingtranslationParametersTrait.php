<?php

namespace IlBronza\TranslationsManager\Http\Controllers\CRUDTraits;

trait CRUDMissingtranslationParametersTrait
{
    public static $tables = [

        'index' => [
            'translationPrefix' => 'translationsmanager::fields',
            'fields' => 
            [
                'language' => [
                    'type' => 'flat',
                    'width' => '25px'
                ],
                'mySelfSee' => 'links.see',
                'scope' => 'flat',
                'filename' => 'flat',
                'string' => 'flat',
                'mySelfVariables' => '_fn_getVariablesString',
                'translation' => [
                    'type' => 'editor.text',
                    'width' => '350px'
                ],
                'created_at' => 'dates.date',
                'mySelfDelete' => 'links.delete'
            ]
        ],
        'translated' => [
            'fields' => 
            [
                'user_id' => 'users.name',
                'translated_at' => 'dates.date',
            ]
        ]
    ];

    static $formFields = [
        'common' => [
            'default' => [
                'translation' => ['text' => 'string|required|max:10240'],
            ]
        ]
    ];    
}