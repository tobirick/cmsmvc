<?php
namespace App\Routes;

$languages = \App\Models\Language::getAllLanguages();
$defaultLanguageId = \App\Models\Settings::getSettings()['default_language_id'];

$langString = '/[';

foreach($languages as $language) {
    if($defaultLanguageId !== $language['id']) {
        $langString .= $language['iso'] . '|';
    }
}

if($langString === '/[') {
    $langString .= '|';
}

$langString .= ':languagePublic]?';

$router->map('GET', $langString  . '/', 'DefaultPageController@index');
$router->map('GET', $langString, 'DefaultPageController@index');
$router->map('GET', $langString . '/[*:slug]', 'DefaultPageController@index');