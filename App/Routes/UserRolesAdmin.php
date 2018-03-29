<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/users/roles', requireLogin('Admin\UserRolesController@index'));

$router->map('POST', '/admin/roles', requireLogin('Admin\UserRolesController@getUserRoles'));
$router->map('POST', '/admin/roles/[i:id]/permissions', requireLogin('Admin\UserRolesController@getPermissionsForRole'));
$router->map('POST', '/admin/roles/permissions', requireLogin('Admin\UserRolesController@getPermissions'));
$router->map('POST', '/admin/roles/edit', requireLogin('Admin\UserRolesController@updateUserRoles'));
$router->map('POST', '/admin/roles/create', requireLogin('Admin\UserRolesController@createUserRole'));