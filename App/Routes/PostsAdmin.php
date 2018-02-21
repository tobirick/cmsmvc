<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/posts', requireLogin('Admin\PostsController@index'));
$router->map('GET', $langString . '/admin/posts/create', requireLogin('Admin\PostsController@create'));
$router->map('GET', $langString . '/admin/posts/[i:id]/edit', requireLogin('Admin\PostsController@edit'));

$router->map('POST', '/admin/posts', requireLogin('Admin\PostsController@store'));
$router->map('POST', '/admin/posts/[i:id]', requireLogin('Admin\PagesController@updatedestroy'));