<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/forms', requireLogin('Admin\FormsController@index'));