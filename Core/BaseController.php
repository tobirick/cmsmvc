<?php
namespace Core;

use \App\Models\User;

class BaseController {
    public function render($template, $args = []) {
        $csrf = new CSRF();
        $pages = \App\Models\DefaultPage::getAllPages();
        $shares = [
            ['key' => 'user', 'value' =>  self::getUser()],
            ['key' => 'csrf', 'value' => $csrf->getToken()],
            ['key' => 'pages', 'value' => $pages]
        ];
        $view = new View();
        $view->render($template, $args, $shares);
    }

    public function redirect($url) {
        header('Location: '.$url );
    }

    public function getUser() {
        if (isset($_SESSION['userid'])) {
            return User::findById($_SESSION['userid']);        
        }
        return false;
    }
}