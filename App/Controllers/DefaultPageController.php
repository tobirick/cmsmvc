<?php

namespace App\Controllers;

use \Core\BaseController;

class DefaultPageController extends BaseController {
    public function index($args) {
        self::render('public/themes/trtheme/default-page', $args['page-args']);
    }
}