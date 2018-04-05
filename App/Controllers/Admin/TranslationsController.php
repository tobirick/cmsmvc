<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Translation;
use \App\Models\Language;
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
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

    CSRF::checkTokenAjax($decoded['csrf_token']);

    $translations = Translation::getAllTranslations();

    header('Content-type: application/json');
    $data = [];
    $data['csrfToken'] = CSRF::getToken();
    $data['translations'] = $translations;

    echo json_encode($data);
  }

  public function createTranslation() {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

    CSRF::checkTokenAjax($decoded['csrf_token']);
    $translations = [];

    $languages = Language::getAllLanguages();

    foreach($languages as $language) {
      $newTranslation = Translation::addTranslation($language['id'], $decoded['translation']);
      $translations[] = $newTranslation;
    }


    header('Content-type: application/json');
    $data = [];
    $data['csrfToken'] = CSRF::getToken();
    $data['translations'] = $translations;

    echo json_encode($data);
  }

  public function updateTranslations($params) {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

    CSRF::checkTokenAjax($decoded['csrf_token']);

    foreach($decoded['translations'] as $translation) {
      Translation::updateTranslationByID($translation['id'], $translation);
    }

    header('Content-type: application/json');
    $data = [];
    $data['csrfToken'] = CSRF::getToken();

    echo json_encode($data);
  }

  public function deleteTranslation($params) {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

    CSRF::checkTokenAjax($decoded['csrf_token']);

    Translation::deleteTranslationByID($params['params']['id']);

    header('Content-type: application/json');
    $data = [];
    $data['csrfToken'] = CSRF::getToken();

    echo json_encode($data);
  }
}