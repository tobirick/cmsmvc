<?php

namespace App\Controllers;

use \Core\BaseController;
use \App\Models\Theme;
use \App\Models\DefaultPage;

class DefaultPageController extends BaseController {
    public function index($args) {
       if(!$args['page-args']['is_active'] && !self::getUser()) {
         self::publicRedirect('/');
       }

       $homePage = DefaultPage::getHomePage();
       
       if($homePage['id'] === $args['page-args']['id'] && isset($args['params']['slug'])) {
          self::publicRedirect('/');
      }

      if(!$args['page-args']) {
         self::publicRedirect('/');
         exit;
      }

      $activeTheme = Theme::getActiveTheme();
      self::render('public/themes/' . $activeTheme['name'] . '/default-page', $args['page-args']);
    }
}