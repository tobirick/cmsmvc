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
            $details = explode("@", $match['target']);
            $this->controller = $this->namespace . $details[0];
            $this->method = $details[1];

            $this->params = [
                'params' => $match['params']
            ];

 	    $this->setLanguage($match);        
        $language = self::$language->getCurrentLanguage();
        $_SESSION['lang'] = $language;
        self::$language->setLanguage($language);

        if(isset($this->params['params']['languagePublic']) && $this->params['params']['languagePublic']) {
            $lang = \App\Models\Language::getLanguageByISO($this->params['params']['languagePublic']);
         } else {
            $lang = \App\Models\Language::getDefaultLanguage(true);
         }

         $langID = $lang['id'];
         $this->params['lang_id'] = $langID;
         
         self::$currentPublicLanguage = $lang;
         $_SESSION['publicLang'] = self::$currentPublicLanguage;


            if(in_array($this->controller, $this->defaultPages)) {

               if(isset($this->params['params']['slug'])) {
                  $slug = $this->params['params']['slug'];
               } else {
                  $slug = DefaultPage::getHomePage($langID)['slug'];
               }
               
               $data = [
                   'slug' => $slug
               ];

               $page = new DefaultPage($data);
               $pageData = $page->getPageBySlug($langID);
               if($pageData) {
                  $this->params['page-args'] = $pageData;
                  $this->params['page-args']['hreflangs'] = DefaultPage::getHrefLangs($pageData["id"]);
               } else {
                    $ctrl = new \App\Controllers\DefaultPageController;
                    call_user_func([$ctrl,'error'], $this->params);
                    return;
               }
            }
            $ctrl = new $this->controller();
            call_user_func([$ctrl, $this->method], $this->params);

        } else {
            $lang = \App\Models\Language::getDefaultLanguage(true);
            self::$currentPublicLanguage = $lang;
            $_SESSION['publicLang'] = self::$currentPublicLanguage;
            
            $ctrl = new \App\Controllers\DefaultPageController;
            call_user_func([$ctrl,'error'], $this->params);
        }
    }
}