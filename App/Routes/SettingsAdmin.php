<?php

namespace App\Routes;

$router->map('GET', '/admin/settings', requireLogin('Admin\SettingsController@index'));