<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/translations', requireLogin('Admin\TranslationsController@index'));

$router->map('POST', '/admin/translations', requireLogin('Admin\TranslationsController@getTranslations'));
$router->map('POST', '/admin/translations/[i:id]/edit', requireLogin('Admin\TranslationsController@updateTranslations'));
$router->map('POST', '/admin/translations/create', requireLogin('Admin\TranslationsController@createTranslation'));
$router->map('POST', '/admin/translations/delete', requireLogin('Admin\TranslationsController@deleteTranslations'));