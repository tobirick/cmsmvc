<?php

namespace App\Controllers\Admin;

use \Core\BaseController;

class ThemesController extends BaseController {
    public function index() {
        self::render('admin/themes/index');
    }
}