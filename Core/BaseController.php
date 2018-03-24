<?php
namespace Core;

use \App\Models\User;

class BaseController {
   private $publicPages = ['App\Controllers\DefaultPageController', 'App\Controllers\DefaultPostController'];

    public function render($template, $args = []) {
        $csrf = new CSRF();
        $pages = \App\Models\DefaultPage::getAllPages();
        $mainMenuPages = \App\Models\Menu::getActiveMenuPages();
        $getAllMenuNames = \App\Models\Menu::getAllMenuTypeNames();
        $activeThemePath = \App\Models\Theme::getActiveTheme();
        // Language
        $language = Router::getLanguage();
        $languagesArray = $language->getLanguagesArray();
        $currentLanguage = $language->getCurrentLanguage();
        $allLanguages = $language->getAllLanguages();
        $settings = \App\Models\Settings::getSettings();
        $shares = [
            ['key' => 'user', 'value' =>  self::getUser()],
            ['key' => 'pages', 'value' => $pages],
            ['key' => 'mainmenupages', 'value' => $mainMenuPages],
            ['key' => 'activetheme', 'value' => $activeThemePath],
            ['key' => 'allmenus', 'value' => $getAllMenuNames],
            ['key' => 'lang', 'value' => $languagesArray],
            ['key' => 'curLang', 'value' => $currentLanguage],
            ['key' => 'allLanguages', 'value' => $allLanguages],
            ['key' => 'settings', 'value' => $settings]
        ];

         if(!in_array(get_class($this), $this->publicPages)) {
            $shares[] = ['key' => 'csrf', 'value' => $csrf->getToken()];
         }

        $view = new View();
        $view->render($template, $args, $shares);
    }

    public static function redirect($url) {
        $language = Router::getLanguage();
        $redirectTo = '/' . $language->getCurrentLanguage() . $url;
        header('Location: ' . $redirectTo  );
    }

    public function getUser() {
        if (isset($_SESSION['userid'])) {
            return User::findById($_SESSION['userid']);        
        }
        return false;
    }
}