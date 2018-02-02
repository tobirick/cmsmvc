<?php

namespace App\Routes;

$router->map('GET', '/admin/posts', requireLogin('Admin\PostsController@index'));
$router->map('GET', '/admin/posts/create', requireLogin('Admin\PostsController@create'));
$router->map('GET', '/admin/posts/[i:id]/edit', requireLogin('Admin\PostsController@edit'));

$router->map('POST', '/admin/posts', requireLogin('Admin\PostsController@store'));
$router->map('PUT', '/admin/posts/[i:id]', requireLogin('Admin\PostsController@update'));
$router->map('DELETE', '/admin/posts/[i:id]', requireLogin('Admin\PostsController@destroy'));