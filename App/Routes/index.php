<?php
$router = new AltoRouter();

$langString = '/[en|de:language]';

## Middlewares ##
function loggedIn($ctrl) {
    if(!isset($_SESSION['userid'])) {
        return $ctrl;
    }
    return 'Admin\DashboardController@index';
}

function requireLogin($ctrl) {
    if(isset($_SESSION['userid'])) {
        return $ctrl;
    }
    return 'Admin\LoginController@index';
}

## Base URLs ##
$router->map('GET', '/', 'IndexController@index');
$router->map('GET', $langString . '/admin/dashboard', requireLogin('Admin\DashboardController@index'));
$router->map('POST', '/changelang', requireLogin('Admin\LanguageController@changeLang'));

## Admin ##
require_once(__DIR__ . '/Auth.php');
require_once(__DIR__ . '/PagesAdmin.php');
require_once(__DIR__ . '/PostsAdmin.php');
require_once(__DIR__ . '/MenusAdmin.php');
require_once(__DIR__ . '/PagebuilderAdmin.php');
require_once(__DIR__ . '/ThemesAdmin.php');
require_once(__DIR__ . '/SettingsAdmin.php');

## Public ##
require_once(__DIR__ . '/PagesPublic.php');