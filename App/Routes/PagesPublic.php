<?php

namespace App\Routes;

$languages = \App\Models\Language::getAllLanguages();

$langString = '/[';

foreach($languages as $language) {
   $langString .= $language['iso'] . '|';
}

$langString .= ':languagePublic]?';

$router->map('GET', $langString  . '/', 'DefaultPageController@index');
$router->map('GET', $langString . '/[a:slug]', 'DefaultPageController@index');