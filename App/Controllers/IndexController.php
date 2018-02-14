<?php
namespace App\Controllers;

use \Core\BaseController;
use \App\Models\Theme;

class IndexController extends BaseController {  
    public function index() {
        $activeThemePath = Theme::getActiveTheme();
        self::render('public/themes/' . $activeThemePath . '/index', [
            'test' => 'test'
        ]);
    }
}