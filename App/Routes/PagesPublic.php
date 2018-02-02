<?php

namespace App\Routes;

$pages = \App\Models\DefaultPage::getAllPages();
foreach($pages as $page) {
    $router->map('GET', '/'.$page['slug'], 'DefaultPageController@index');
}