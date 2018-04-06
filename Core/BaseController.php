<?php
namespace Core;

use \App\Models\User;
use \App\Models\Theme;
use \Core\Permission;

class BaseController {
    private $publicPages = ['App\Controllers\IndexController', 'App\Controllers\DefaultPageController', 'App\Controllers\DefaultPostController'];

    public function render($template, $args = []) {
        $pages = \App\Models\DefaultPage::getAllPages();
        $mainMenuPages = \App\Models\Menu::getActiveMenuPages();
        $activeTheme = \App\Models\Theme::getActiveTheme();
        $settings = \App\Models\Settings::getSettings();
        $publicLanguages = \App\Models\Language::getAllLanguages();
        $shares = [
            ['key' => 'user', 'value' =>  self::getUser()],
            ['key' => 'pages', 'value' => $pages],
            ['key' => 'mainmenupages', 'value' => $mainMenuPages],
            ['key' => 'activetheme', 'value' => $activeTheme['name']],
            ['key' => 'themesettings', 'value' => $activeTheme],
            ['key' => 'settings', 'value' => $settings],
            ['key' => 'publiclanguages', 'value' => $publicLanguages]
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

        // Admin Pages
         if(!in_array(get_class($this), $this->publicPages)) {
            $csrf = new CSRF();
            $language = Router::getLanguage();
            $languagesArray = $language->getLanguagesArray();
            $currentLanguage = $language->getCurrentLanguage();
            $allLanguages = $language->getAllLanguages();
            $getAllMenuNames = \App\Models\Menu::getAllMenuTypeNames();

            $shares[] = ['key' => 'csrf', 'value' => $csrf->getToken()];
            $shares[] = ['key' => 'lang', 'value' => $languagesArray];
            $shares[] = ['key' => 'curLang', 'value' => $currentLanguage];
            $shares[] = ['key' => 'allLanguages', 'value' => $allLanguages];
            $shares[] = ['key' => 'allmenus', 'value' => $getAllMenuNames];
         }

         // Public pages
         if(in_array(get_class($this), $this->publicPages)) {
            $currentPublicLanguage = Router::getCurrentPublicLanguage();
            $footercols = [];
            foreach(json_decode($activeTheme['footer_layout'], true)['columns'] as $footercol) {
                $footercol['html'] = self::doShortcode($footercol['html']);
                $footercol['title'] = self::doShortcode($footercol['title']);
                $footercols[] = $footercol;
            }

            $shares[] = ['key' => 'footercols', 'value' => $footercols];
            $shares[] = ['key' => 'settings', 'value' => $settings];
            $shares[] = ['key' => 'currentpubliclanguage', 'value' => $currentPublicLanguage];
         }

         //Public pages maintenance mode
         if(in_array(get_class($this), $this->publicPages) && $settings['maintenance_mode'] && !self::getUser()) {
            self::redirect('/admin/dashboard');
         }

        $view = new View();
        $view->render($template, $args, $shares);
    }

    public static function doShortcode($html) {
        $regex = "/\[(.*?)\]/";
        preg_match_all($regex, $html, $matches);
        $returnHTML = $html;

        for($i = 0; $i < count($matches[1]); $i++){
            $match = $matches[1][$i];
            $array = explode(' ', $match);
            $shortcode = new Shortcode();
            $newHTML = $shortcode->call($array);
    
            $string = str_replace($matches[0][$i], $newHTML, $returnHTML);
            $returnHTML = $string;
        }

        return $returnHTML;
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

    public static function publicRedirect($url) {
      $currentPublicLanguage = Router::getCurrentPublicLanguage();
      $redirectTo = '/' . $currentPublicLanguage['iso'] . $url;
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