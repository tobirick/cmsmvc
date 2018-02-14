<?php

namespace App\Controllers;

use \Core\BaseController;
use \App\Models\Theme;

class DefaultPageController extends BaseController {
    public function index($args) {
        $activeThemePath = Theme::getActiveTheme();
        self::render('public/themes/' . $activeThemePath . '/default-page', $args['page-args']);
    }
}