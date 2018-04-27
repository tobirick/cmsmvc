<?php

namespace App\Controllers;

use \Core\BaseController;
use \App\Models\Theme;
use \App\Models\DefaultPage;

class DefaultPageController extends BaseController {
    public function index($args) {
      $homePage = DefaultPage::getHomePage();

       if(!$args['page-args']['is_active'] && !self::getUser()) {
         self::render('error/404');
         return;
       } else if($homePage && $homePage['id'] === $args['page-args']['id'] && isset($args['params']['slug'])) {
         self::publicRedirect('/');
         return;
       }

      $activeTheme = Theme::getActiveTheme();
      self::render('public/themes/' . $activeTheme['name'] . '/default-page', $args['page-args']);
    }
}