<?php
namespace Core;

use \App\Models\DefaultPage;

class Router {
    private $controller;
    private $method;
    private $params;
    private $namespace;
    private static $language;
    private static $currentPublicLanguage;
    private $defaultPages = ['App\Controllers\DefaultPageController', 'App\Controllers\DefaultPostController', 'App\Controllers\IndexController'];

    public function __construct($router) {
        $this->namespace = 'App\Controllers\\';
        self::$language = new Language(isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en');
        $match = $router->match();

        $this->matchRoute($match);
    }

    public static function getLanguage() {
        return self::$language;
    }

    public static function getCurrentPublicLanguage() {
       return self::$currentPublicLanguage;
    }

    private function setLanguage($match) {
        if(isset($match['params']['language'])) {
            self::$language->setLanguage($match['params']['language']);
        } else {
            if(isset($_SESSION['lang'])) {
                self::$language->setLanguage($_SESSION['lang']);
            }
        }
    }

    private function matchRoute($match) {
        if($match) {
            $this->setLanguage($match);        
            $language = self::$language->getCurrentLanguage();
            $_SESSION['lang'] = $language;
            self::$language->setLanguage($language);
            
            $details = explode("@", $match['target']);
            $this->controller = $this->namespace . $details[0];
            $this->method = $details[1];

            $this->params = [
                'params' => $match['params']
            ];


            if(in_array($this->controller, $this->defaultPages)) {
               if(isset($this->params['params']['slug'])) {
                  $slug = $this->params['params']['slug'];
               } else {
                  $slug = DefaultPage::getHomePage()['slug'];
               }

               if(isset($this->params['params']['languagePublic']) && $this->params['params']['languagePublic']) {
                  $lang = \App\Models\Language::getLanguageByISO($this->params['params']['languagePublic']);
               } else if(!isset($_SESSION['publicLang'])) {
                  $lang = \App\Models\Language::getDefaultLanguage();
               } else {
                  $lang = $_SESSION['publicLang'];
               }

               $langID = $lang['id'];

               $data = [
                   'slug' => $slug
               ];

               self::$currentPublicLanguage = $lang;
               $_SESSION['publicLang'] = self::$currentPublicLanguage;
               
               $page = new DefaultPage($data);
               $this->params['page-args'] = $page->getPageBySlug($langID);
            }

            $ctrl = new $this->controller();
            call_user_func([$ctrl, $this->method], $this->params);
        } else {
            $view = new View();
            $view->render('error/404');
        }
    }
}