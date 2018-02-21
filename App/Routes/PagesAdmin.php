<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/pages', requireLogin('Admin\PagesController@index'));
$router->map('GET', $langString . '/admin/pages/create', requireLogin('Admin\PagesController@create'));
$router->map('GET', $langString . '/admin/pages/[i:id]/edit', requireLogin('Admin\PagesController@edit'));

$router->map('POST', '/admin/pages', requireLogin('Admin\PagesController@store'));
$router->map('POST', '/admin/pages/[i:id]', requireLogin('Admin\PagesController@updatedestroy'));

// Knockout
$router->map('POST', '/pages', requireLogin('Admin\PagesController@getAllPages'));