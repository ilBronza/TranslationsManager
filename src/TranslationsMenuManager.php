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
            'text' => 'generals.translations',
            'href' => route('missingtranslations.index'),
            'roles' => ['administrator']
        ]);

        $button->addChild($translationsButton);

    }
}