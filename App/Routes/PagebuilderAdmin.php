<?php

namespace App\Routes;

$router->map('GET', '/admin/pagebuilder', requireLogin('Admin\PagebuilderController@index'));
$router->map('GET', '/admin/pagebuilder/create', requireLogin('Admin\PagebuilderController@create'));
$router->map('GET', '/admin/pagebuilder/[i:id]/edit', requireLogin('Admin\PagebuilderController@edit'));

$router->map('POST', '/admin/pagebuilder', requireLogin('Admin\PagebuilderController@store'));
$router->map('POST', '/admin/pagebuilder/[i:id]', requireLogin('Admin\PagebuilderController@updatedestroy'));