<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/settings', requireLogin('Admin\SettingsController@index'));