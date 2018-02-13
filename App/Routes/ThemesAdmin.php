<?php

namespace App\Routes;

$router->map('GET', '/admin/themes', requireLogin('Admin\ThemesController@index'));