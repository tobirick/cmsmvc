<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/themes', requireLogin('Admin\ThemesController@index'));
$router->map('GET', $langString . '/admin/themes/create', requireLogin('Admin\ThemesController@create'));
$router->map('GET', $langString . '/admin/themes/[i:id]/edit', requireLogin('Admin\ThemesController@edit'));

$router->map('POST', '/admin/themes', requireLogin('Admin\ThemesController@store'));
$router->map('POST', '/admin/themes/[a:name]/[i:id]', requireLogin('Admin\ThemesController@updatedestroy'));

// Knockout
$router->map('POST', '/admin/themes/[i:id]', requireLogin('Admin\ThemesController@getThemeSettings'));
$router->map('POST', '/admin/themes/[i:id]/settings', requireLogin('Admin\ThemesController@updateThemeSettings'));