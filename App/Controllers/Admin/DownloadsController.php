<?php

namespace App\Controllers\Admin;

use \Core\BaseController;

class DownloadsController extends BaseController {
    public function index() {
        self::render('admin/downloads/index');
    }
}