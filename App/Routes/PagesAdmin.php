<?php

namespace App\Routes;

$router->map('GET', '/admin/pages', requireLogin('Admin\PagesController@index'));
$router->map('GET', '/admin/pages/create', requireLogin('Admin\PagesController@create'));
$router->map('GET', '/admin/pages/[i:id]/edit', requireLogin('Admin\PagesController@edit'));

$router->map('POST', '/admin/pages', requireLogin('Admin\PagesController@store'));
$router->map('POST', '/admin/pages/[i:id]', requireLogin('Admin\PagesController@updatedestroy'));