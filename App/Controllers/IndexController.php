<?php
namespace App\Controllers;

use \Core\BaseController;

class IndexController extends BaseController {  
    public function index() {
        self::render('public/themes/trtheme/index', [
            'test' => 'test'
        ]);
    }
}