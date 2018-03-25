<?php

namespace App\Controllers;

use \Core\BaseController;
use \App\Models\Theme;

class DefaultPageController extends BaseController {
    public function index($args) {
        $activeTheme = Theme::getActiveTheme();
        self::render('public/themes/' . $activeTheme['name'] . '/default-page', $args['page-args']);
    }
}