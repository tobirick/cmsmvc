<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/themes', requireLogin('Admin\ThemesController@index'));
$router->map('GET', $langString . '/admin/themes/create', requireLogin('Admin\ThemesController@create'));

$router->map('POST', '/admin/themes', requireLogin('Admin\ThemesController@store'));
$router->map('POST', '/admin/themes/[a:name]/[i:id]', requireLogin('Admin\ThemesController@updatedestroy'));