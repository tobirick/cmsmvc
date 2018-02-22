<?php
namespace Core;

use \App\Models\DefaultPage;

class Router {
    private $controller;
    private $method;
    private $params;
    private $namespace;
    private static $language;
    private $defaultPages = ['App\Controllers\DefaultPageController', 'App\Controllers\DefaultPostController'];

    public function __construct($router) {
        $this->namespace = 'App\Controllers\\';
        self::$language = new Language(isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en');
        $match = $router->match();

        $this->matchRoute($match);
    }

    public static function getLanguage() {
        return self::$language;
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
                $slug = substr($_SERVER['REQUEST_URI'],1);
                $data = [
                    'slug' => $slug
                ];
                $page = new DefaultPage($data);
                $this->params['page-args'] = $page->getPageBySlug();
            }

            call_user_func([$this->controller, $this->method], $this->params);
        } else {
            $view = new View();
            $view->render('error/404');
        }
    }
}