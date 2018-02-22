<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/menus', requireLogin('Admin\MenusController@index'));
$router->map('GET', $langString . '/admin/menus/create', requireLogin('Admin\MenusController@create'));
$router->map('GET', $langString . '/admin/menus/[i:id]/edit', requireLogin('Admin\MenusController@edit'));

$router->map('POST', '/admin/menus', requireLogin('Admin\MenusController@store'));
$router->map('POST', '/admin/menus/[i:id]', requireLogin('Admin\MenusController@updatedestroy'));

$router->map('POST', '/admin/menus/[i:id]/menuitems', requireLogin('Admin\MenuItemsController@getAllListItems'));
$router->map('POST', '/admin/menus/[i:id]/menuitems', requireLogin('Admin\MenuItemsController@store'));
$router->map('POST', '/admin/menus/[i:id]/menuitems/position', requireLogin('Admin\MenuItemsController@updatePosition'));
$router->map('POST', '/admin/menus/[i:id]/menuitems/[i:menuitemid]', requireLogin('Admin\MenuItemsController@updatedestroy'));