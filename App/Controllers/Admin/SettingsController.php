<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Settings;
use \App\Models\Language;
use \App\Models\DefaultPage;
use \Core\CSRF;

class SettingsController extends BaseController {
    public function index() {
      if(!self::checkPermission('view_settings')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }

        $settings = Settings::getSettings();
    
        self::render('admin/settings/index', [
            'settings' => $settings
        ]);
    }

    public function update() {
        if(!self::checkPermission('change_settings')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        CSRF::checkToken();
        if(isset($_POST)) {
           if(!isset($_POST['settings']['maintenance_mode'])) {
               Settings::updateSetting([
                  'name' => 'maintenance_mode',
                  'value' => 0
            ]);
           }
            foreach($_POST['settings'] as $index => $setting) {
                Settings::updateSetting([
                    'name' => $index,
                    'value' => $setting
                ]);
            }
            self::redirect('/admin/settings');
        }
    }

    public function languageIndex() {
      if(!self::checkPermission('view_language')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }

      $languages = Language::getAllLanguages();
      self::render('admin/languages/index', [
         'languages' => $languages
      ]);
    }

    public function languageCreate() {
      if(!self::checkPermission('add_language')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }
      self::render('admin/languages/create');
    }

    public function languageEdit($params) {
      if(!self::checkPermission('edit_language')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }
       $language = Language::getLanguageById($params['params']['id']);
      self::render('admin/languages/edit', [
         'language' => $language
      ]);
    }

    public function languageStore() {
      if(!self::checkPermission('add_language')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }
      CSRF::checkToken();
      if(isset($_POST)) {
        $errors = Language::validate($_POST['language']);

        if(!$errors) {
            $language = Language::addLanguage($_POST['language']);
            $pages = DefaultPage::getAllPages();
            foreach($pages as $page) {
                DefaultPage::addPageContents($page['id'], $language['id']);
            }
            self::redirect('/admin/settings/languages');
        } else {
            self::redirect('/admin/settings/languages/create');
        }
      }
    }

    public function languageUpdatedestroy($params) {
      CSRF::checkToken();
      if(isset($_POST)) {
          if($_POST['_METHOD'] === 'DELETE') {
              self::languageDelete($params);
          } else if ($_POST['_METHOD'] === 'PUT') {
              self::languageUpdate($params, $_POST);
          }
      }
    }

    public function languageDelete($params) {
      if(!self::checkPermission('delete_language')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }

      if(Language::getDefaultLanguage()['id'] !== $params['params']['id']) {
         Language::deleteLanguage($params['params']['id']);
         self::redirect('/admin/settings/languages');
      } else {
         self::addFlash('error', self::getTrans('You can not delete the default language!'));
         self::redirect('/admin/settings/languages');
      }
  }

  public function languageUpdate($params, $post) {
   if(!self::checkPermission('edit_language')) {         
      self::addFlash('error', self::getTrans('You have not the permission to do that!'));
      self::redirect('/admin/dashboard');
   }
   
   $errors = Language::validate($post['language']);
   if(!$errors) {
       Language::updateLanguage($params['params']['id'], $post['language']);
       self::redirect('/admin/settings/languages');
   } else {
       self::redirect('/admin/settings/languages/' . $params['params']['id'] . '/edit');
   }
  }

  public function getAllLanguages() {
   $content = trim(file_get_contents("php://input"));
   $decoded = json_decode($content, true);

   CSRF::checkTokenAjax($decoded['csrf_token']);

   $languages = Language::getAllLanguages();

   header('Content-type: application/json');

   $data['csrfToken'] = CSRF::getToken();
   $data['languages'] = $languages;
   
   echo json_encode($data);
  }
}