<?php

namespace App\Routes;

$router->map('GET', $langString . '/admin/pagebuilder', requireLogin('Admin\PagebuilderController@index'));
$router->map('GET', $langString . '/admin/pagebuilder/create', requireLogin('Admin\PagebuilderController@create'));
$router->map('GET', $langString . '/admin/pagebuilder/[i:id]/edit', requireLogin('Admin\PagebuilderController@edit'));

$router->map('POST', '/admin/pagebuilder', requireLogin('Admin\PagebuilderController@store'));
$router->map('POST', '/admin/pagebuilder/[i:id]', requireLogin('Admin\PagebuilderController@updatedestroy'));

// Knockout
$router->map('POST', '/pagebuilder/items', requireLogin('Admin\PagebuilderController@getAllPagebuilderItems'));

$router->map('POST', '/pagebuilder', requireLogin('Admin\PagebuilderController@savePagebuilder'));

$router->map('GET', '/pages/[i:pageid]/pagebuilder/sections', requireLogin('Admin\PagebuilderController@getSectionsByPageID'));
$router->map('GET', '/pages/pagebuilder/sections/[i:sectionid]/rows', requireLogin('Admin\PagebuilderController@getRowsBySectionID'));
$router->map('GET', '/pages/pagebuilder/sections/rows/[i:rowid]/columnrows', requireLogin('Admin\PagebuilderController@getColumnRowsByRowID'));
$router->map('GET', '/pages/pagebuilder/sections/rows/columnrows/[i:columnrowid]/columns', requireLogin('Admin\PagebuilderController@getColumnsByColumnRowID'));
$router->map('GET', '/pages/pagebuilder/sections/rows/columnrows/columns/[i:columnid]/element', requireLogin('Admin\PagebuilderController@getElementByColumnID'));