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

    public function __construct($router, $language) {
        $this->namespace = 'App\Controllers\\';
        self::$language = $language;
        $match = $router->match();

        $this->matchRoute($match);
    }

    public static function getLanguage() {
        return self::$language;
    }

    private function matchRoute($match) {
        if($match) {
            $language = $match['params']['language'] ? $match['params']['language'] : $language->getCurrentLanguage();
            if(isset(self::$language)) self::$language->setLanguage($language);
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