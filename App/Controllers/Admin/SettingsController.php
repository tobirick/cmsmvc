<?php

namespace App\Controllers\Admin;

use \Core\BaseController;

class SettingsController extends BaseController {
    public function index() {
        self::render('admin/settings/index');
    }
}