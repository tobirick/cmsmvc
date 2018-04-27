<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/settings', requireLogin('Admin\SettingsController@index'));
$router->map('POST', '/admin/settings', requireLogin('Admin\SettingsController@update'));

$router->map('GET', '/admin/settings/backup/db', requireLogin('Admin\SettingsController@startDBBackup'));
$router->map('GET', '/admin/settings/backup/ftp', requireLogin('Admin\SettingsController@startFTPBackup'));

$router->map('GET', $langString . '/admin/settings/languages', requireLogin('Admin\SettingsController@languageIndex'));
$router->map('GET', $langString . '/admin/settings/languages/create', requireLogin('Admin\SettingsController@languageCreate'));
$router->map('GET', $langString . '/admin/settings/languages/[i:id]/edit', requireLogin('Admin\SettingsController@languageEdit'));

$router->map('POST', '/admin/settings/languages', requireLogin('Admin\SettingsController@languageStore'));
$router->map('POST', '/admin/settings/languages/[i:id]', requireLogin('Admin\SettingsController@languageUpdatedestroy'));

// Knockout
$router->map('POST', '/languages', requireLogin('Admin\SettingsController@getAllLanguages'));