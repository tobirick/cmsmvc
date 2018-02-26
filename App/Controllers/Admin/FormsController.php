<?php

namespace App\Controllers\Admin;

use \Core\BaseController;

class FormsController extends BaseController {
    public function index() {
        self::render('admin/forms/index');
    }
}