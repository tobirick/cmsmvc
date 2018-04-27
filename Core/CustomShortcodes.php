<?php

namespace Core;

class CustomShortcodes {
    public static function footerMenu($methodParams) {
        $array = explode(' ', $methodParams);
        for ($i = 0; $i < sizeof($array); $i++) {
            $varArray = explode('=', $array[$i]);
            ${$varArray[0]} = $varArray[1];
        }

        $menuItems = \App\Models\Menu::getMenuItemsWithSlugByMenuID($id);
        $currentPublicLanguage = Router::getCurrentPublicLanguage();

        $html = '<ul class="footer-_nav">';

        foreach ($menuItems as $menuItem) {
            $url = '';
            if ($currentPublicLanguage['id'] === $menuItem['language_id']) {
                $html .= "<li class='footer__nav-item'><a href='/{$currentPublicLanguage['iso']}/{$menuItem['slug']}' class='footer__nav-item-link {$menuItem['css_class']}'>{$menuItem['name']}</a></li>";
            }
        }

        $html .= '</ul>';

        return $html;
    }

    public static function translate($methodParams) {
        $array = explode(' ', $methodParams);

        for ($i = 0; $i < sizeof($array); $i++) {
            $varArray = explode('=', $array[$i]);
            ${$varArray[0]} = $varArray[1];
        }

        $currentPublicLanguage = Router::getCurrentPublicLanguage();
        $defaultLanguage = \App\Models\Language::getDefaultLanguage();
        $translation = \App\Models\Translation::getTranslationByKey($name, $currentPublicLanguage['id'])['value'];

        if (!$translation) {
            $translation = \App\Models\Translation::getTranslationByKey($name, $defaultLanguage['id'])['value'];
        }

        return $translation;
    }
}
