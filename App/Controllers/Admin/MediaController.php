<?php

namespace App\Controllers\Admin;

use \Core\BaseController;

class MediaController extends BaseController {
    public function index() {
        self::render('admin/media/index');
    }
}