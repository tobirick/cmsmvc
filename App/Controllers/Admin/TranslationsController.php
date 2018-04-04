<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Translations;
use \Core\CSRF;

class TranslationsController extends BaseController {
  public function index() {
    if(!self::checkPermission('view_translations')) {         
      self::addFlash('error', self::getTrans('You have not the permission to do that!'));
      self::redirect('/admin/dashboard');
  }
    self::render('admin/translations/index');
  }

  public function getTranslations() {

  }

  public function createTranslation() {
    
  }

  public function updateTranslation() {
    
  }

  public function deleteTranslation() {

  }
}