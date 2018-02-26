<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/downloads', requireLogin('Admin\DownloadsController@index'));