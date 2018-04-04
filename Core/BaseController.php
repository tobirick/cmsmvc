<?php
namespace Core;

use \App\Models\User;
use \App\Models\Theme;
use \Core\Permission;

class BaseController {
    private $publicPages = ['App\Controllers\IndexController', 'App\Controllers\DefaultPageController', 'App\Controllers\DefaultPostController'];

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
        $publicLanguages = \App\Models\Language::getAllLanguages();
        $currentPublicLanguage = Router::getCurrentPublicLanguage();
        $settings = \App\Models\Settings::getSettings();
        $footercols = self::doFooterShortode(json_decode($activeTheme['footer_layout'], true)['columns']);
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
            ['key' => 'publiclanguages', 'value' => $publicLanguages],
            ['key' => 'currentpubliclanguage', 'value' => $currentPublicLanguage]
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

         //Public pages maintenance mode
         if(in_array(get_class($this), $this->publicPages) && $settings['maintenance_mode'] && !self::getUser()) {
            self::redirect('/admin/dashboard');
         }

        $view = new View();
        $view->render($template, $args, $shares);
    }

    public static function doFooterShortode($footerCols) {
        $returnFooterCols = [];

        foreach($footerCols as $footerCol) {
            $name = 'menu';
            $regex = "/\[(.*?)\]/";
            preg_match_all($regex, $footerCol['html'], $matches);

            if($matches[0]) {
                for($i = 0; $i < count($matches[1]); $i++){
                    $match = $matches[1][$i];
                    $array = explode(' ', $match);
                    $shortcode = new Shortcode();
                    $newHTML = $shortcode->call($array);
    
                    $string = str_replace($matches[0][$i], $newHTML, $footerCol['html']);
                    $footerCol['html'] = $string;
                    $returnFooterCols[] = $footerCol;
                }
            } else {
                $returnFooterCols[] = $footerCol;
            }
        }
        return $returnFooterCols;
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