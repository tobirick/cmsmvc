<?php

namespace App\Routes;

$router->map('GET', '/admin/themes', requireLogin('Admin\ThemesController@index'));
$router->map('GET', '/admin/themes/create', requireLogin('Admin\ThemesController@create'));
$router->map('GET', '/admin/themes/[a:name]/[i:id]/edit', requireLogin('Admin\ThemesController@edit'));

$router->map('POST', '/admin/themes', requireLogin('Admin\ThemesController@store'));
$router->map('POST', '/admin/themes/[a:name]/[i:id]', requireLogin('Admin\ThemesController@updatedestroy'));