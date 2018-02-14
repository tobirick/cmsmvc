<?php
namespace Core;

use \App\Models\User;

class BaseController {
    public function render($template, $args = []) {
        $csrf = new CSRF();
        $pages = \App\Models\DefaultPage::getAllPages();
        $mainmenupages = \App\Models\Menu::getActiveMenuPages();
        $activeThemePath = \App\Models\Theme::getActiveTheme();
        $shares = [
            ['key' => 'user', 'value' =>  self::getUser()],
            ['key' => 'csrf', 'value' => $csrf->getToken()],
            ['key' => 'pages', 'value' => $pages],
            ['key' => 'mainmenupages', 'value' => $mainmenupages],
            ['key' => 'activetheme', 'value' => $activeThemePath]
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