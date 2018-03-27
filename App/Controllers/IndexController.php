<?php
namespace App\Controllers;

use \Core\BaseController;
use \App\Models\Theme;
use \App\Models\DefaultPage;

class IndexController extends BaseController {  
    public function index() {
        $activeTheme = Theme::getActiveTheme();

        $homePage = DefaultPage::getHomePage();

        self::render('public/themes/' . $activeTheme['name'] . '/default-page', $homePage);
    }
}