<?php

namespace App\Routes;

$router->map('GET', '/admin/login', loggedIn('Admin\LoginController@index'));
$router->map('POST', '/admin/login', loggedIn('Admin\LoginController@login'));
$router->map('GET', '/admin/register', loggedIn('Admin\RegisterController@index'));
$router->map('POST', '/admin/register', loggedIn('Admin\RegisterController@register'));
$router->map('GET', '/admin/logout', requireLogin('Admin\LoginController@logout'));