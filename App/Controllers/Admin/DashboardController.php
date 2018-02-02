<?php

namespace App\Controllers\Admin;

use \Core\BaseController;

class DashboardController extends BaseController {
    public function index() {
        self::render('admin/dashboard/index');
    }
}