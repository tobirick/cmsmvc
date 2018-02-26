<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/media', requireLogin('Admin\MediaController@index'));