<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/users', requireLogin('Admin\UsersController@index'));
$router->map('GET', $langString . '/admin/users/create', requireLogin('Admin\UsersController@create'));
$router->map('GET', $langString . '/admin/users/[i:id]/edit', requireLogin('Admin\UsersController@edit'));

$router->map('POST', '/admin/users', requireLogin('Admin\UsersController@store'));
$router->map('POST', '/admin/users/[i:id]', requireLogin('Admin\UsersController@updatedestroy'));