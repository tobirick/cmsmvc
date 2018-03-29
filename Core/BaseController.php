<?php
namespace Core;

use \App\Models\User;
use \App\Models\Theme;
use \Core\Permission;

class BaseController {
    private $publicPages = ['App\Controllers\DefaultPageController', 'App\Controllers\DefaultPostController'];

    public function render($template, $args = []) {
        $csrf = new CSRF();
        $pages = \App\Models\DefaultPage::getAllPages();
        $mainMenuPages = \App\Models\Menu::getActiveMenuPages();
        $getAllMenuNames = \App\Models\Menu::getAllMenuTypeNames();
        $activeTheme = \App\Models\Theme::getActiveTheme();
        $language = Router::getLanguage();
        $languagesArray = $language->getLanguagesArray();
        $currentLanguage = $language->getCurrentLanguage();
        $allLanguages = $language->getAllLanguages();
        $settings = \App\Models\Settings::getSettings();
        $footercols = json_decode($activeTheme['footer_layout'], true)['columns'];
        $shares = [
            ['key' => 'user', 'value' =>  self::getUser()],
            ['key' => 'pages', 'value' => $pages],
            ['key' => 'mainmenupages', 'value' => $mainMenuPages],
            ['key' => 'activetheme', 'value' => $activeTheme['name']],
            ['key' => 'themesettings', 'value' => $activeTheme],
            ['key' => 'footercols', 'value' => $footercols],
            ['key' => 'allmenus', 'value' => $getAllMenuNames],
            ['key' => 'lang', 'value' => $languagesArray],
            ['key' => 'curLang', 'value' => $currentLanguage],
            ['key' => 'allLanguages', 'value' => $allLanguages],
            ['key' => 'settings', 'value' => $settings],
        ];

        // Minify CSS and JS
        if(filter_var(getenv('DEV'), FILTER_VALIDATE_BOOLEAN)) {
            Theme::combineCSS($activeTheme['name']);
            Theme::combineJS($activeTheme['name']);
        }

        // Flash Messages
        if(isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $shares[] = ['key' => 'flash', 'value' => $flash];
        }

        // Disable CSRF for Public Pages
         if(!in_array(get_class($this), $this->publicPages)) {
            $shares[] = ['key' => 'csrf', 'value' => $csrf->getToken()];
         }

        $view = new View();
        $view->render($template, $args, $shares);
    }

    public static function getTrans($string) {
      $language = Router::getLanguage();
      return $language->getTrans($string);
    }

    public static function redirect($url) {
        $language = Router::getLanguage();
        $redirectTo = '/' . $language->getCurrentLanguage() . $url;
        header('Location: ' . $redirectTo  );
        exit;
    }

    public function getUser() {
        if (isset($_SESSION['userid'])) {
            return User::findById($_SESSION['userid']);        
        }
        return false;
    }
    
    public function checkPermission($permissionname) {
        $id = Permission::getPerm($permissionname);
        if(array_search($id, self::getUser()['permissions']) !== false) {
            return true;
        }

        return false;
    }

    public function addFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
}