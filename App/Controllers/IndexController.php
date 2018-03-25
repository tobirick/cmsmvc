<?php
namespace App\Controllers;

use \Core\BaseController;
use \App\Models\Theme;

class IndexController extends BaseController {  
    public function index() {
        $activeTheme = Theme::getActiveTheme();
        self::render('public/themes/' . $activeTheme['name'] . '/index', [
            'test' => 'test'
        ]);
    }
}