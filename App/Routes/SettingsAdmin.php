<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/settings', requireLogin('Admin\SettingsController@index'));
$router->map('POST', '/admin/settings', requireLogin('Admin\SettingsController@update'));