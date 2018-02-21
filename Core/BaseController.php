<?php
namespace Core;

use \App\Models\User;

class BaseController {
    private static $language;

    public function render($template, $args = []) {
        $csrf = new CSRF();
        $pages = \App\Models\DefaultPage::getAllPages();
        $mainMenuPages = \App\Models\Menu::getActiveMenuPages();
        $getAllMenuNames = \App\Models\Menu::getAllMenuTypeNames();
        $activeThemePath = \App\Models\Theme::getActiveTheme();
        // Language
        self::$language = Router::getLanguage();
        $languagesArray = self::$language->getLanguagesArray();
        $currentLanguage = self::$language->getCurrentLanguage();
        $shares = [
            ['key' => 'user', 'value' =>  self::getUser()],
            ['key' => 'csrf', 'value' => $csrf->getToken()],
            ['key' => 'pages', 'value' => $pages],
            ['key' => 'mainmenupages', 'value' => $mainMenuPages],
            ['key' => 'activetheme', 'value' => $activeThemePath],
            ['key' => 'allmenus', 'value' => $getAllMenuNames],
            ['key' => 'lang', 'value' => $languagesArray],
            ['key' => 'curLang', 'value' => $currentLanguage]
        ];
        $view = new View();
        $view->render($template, $args, $shares);
    }

    public function redirect($url) {
        $language = Router::getLanguage();
        header('Location: /' . $language->getCurrentLanguage() . $url );
    }

    public function getUser() {
        if (isset($_SESSION['userid'])) {
            return User::findById($_SESSION['userid']);        
        }
        return false;
    }
}