<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/media', requireLogin('Admin\MediaController@index'));

$router->map('POST', '/admin/media', requireLogin('Admin\MediaController@store'));
$router->map('POST', '/admin/media/[i:id]', requireLogin('Admin\MediaController@updatedestroy'));

// Knockout
$router->map('POST', '/media', requireLogin('Admin\MediaController@getAllMediaElements'));
$router->map('POST', '/media/images', requireLogin('Admin\MediaController@getAllImages'));
