<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/pagebuilder', requireLogin('Admin\PagebuilderController@index'));
$router->map('GET', $langString . '/admin/pagebuilder/create', requireLogin('Admin\PagebuilderController@create'));
$router->map('GET', $langString . '/admin/pagebuilder/[i:id]/edit', requireLogin('Admin\PagebuilderController@edit'));

$router->map('POST', '/admin/pagebuilder', requireLogin('Admin\PagebuilderController@store'));
$router->map('POST', '/admin/pagebuilder/[i:id]', requireLogin('Admin\PagebuilderController@updatedestroy'));

// Knockout
$router->map('POST', '/pagebuilder/items', requireLogin('Admin\PagebuilderController@getAllPagebuilderItems'));
$router->map('POST', '/pagebuilder/items/[i:id]', requireLogin('Admin\PagebuilderController@getPagebuilderItemByID'));

$router->map('POST', '/pagebuilder/items/[i:id]/edit', requireLogin('Admin\PagebuilderController@updatePagebuilderItem'));
$router->map('POST', '/pagebuilder/items/add', requireLogin('Admin\PagebuilderController@addPagebuilderItem'));

$router->map('POST', '/pagebuilder', requireLogin('Admin\PagebuilderController@savePagebuilder'));

$router->map('POST', '/pages/[i:pageid]/pagebuilder/sections', requireLogin('Admin\PagebuilderController@getSectionsByPageID'));