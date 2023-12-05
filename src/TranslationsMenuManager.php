<?php

namespace IlBronza\TranslationsManager;

class TranslationsMenuManager
{
    public function manageMenuButtons()
    {
        if(! $menu = app('menu'))
            return;

        $button = $menu->provideButton([
                'text' => 'generals.settings',
                'name' => 'settings',
                'icon' => 'gear',
                'roles' => ['administrator']
            ]);

        $button->setFirst();

        $translationsButton = $menu->createButton([
            'name' => 'translations',
            'text' => 'translationsmanager::translationsmanager.translations',
            'roles' => ['administrator'],
            'icon' => 'language',
            'children' => [
                [
                    'icon' => 'pen-to-square',
                    'href' => route('missingtranslations.index'),
                    'text' => 'translationsmanager::translationsmanager.index'
                ],
                [
                    'icon' => 'trash',
                    'href' => route('missingtranslations.resetDB'),
                    'text' => 'translationsmanager::translationsmanager.resetDatabase'
                ],
            ]
        ]);

        $button->addChild($translationsButton);

    }
}