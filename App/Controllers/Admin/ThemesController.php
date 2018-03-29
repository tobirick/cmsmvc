<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Theme;
use \Core\CSRF;

class ThemesController extends BaseController {
    public function index() {
        $themes = Theme::getAllThemeNames();
        self::render('admin/themes/index', [
            'themes' => $themes
        ]);
    }

    public function create() {
        if(!self::checkPermission('add_theme')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        self::render('admin/themes/create');
    }

    public function edit($params) {
        if(!self::checkPermission('edit_theme')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
      $id = $params['params']['id'];
      $theme = Theme::getThemeById($id);
      if($theme) {
         self::render('admin/themes/edit', [
            'theme' => $theme
         ]);
      } else {
         self::render('error/404');
      }
    }

    public function getThemeSettings($params) {
      $content = trim(file_get_contents("php://input"));
      $decoded = json_decode($content, true);

      CSRF::checkTokenAjax($decoded['csrf_token']);

      $theme = Theme::getThemeById($params['params']['id']);
      $theme['css'] = file_get_contents(__DIR__  . '/../../../public/' . $theme['name'] . '/css/customize.css');
      header('Content-type: application/json');
      $data = [];
      $data['csrfToken'] = CSRF::getToken();
      $data['theme'] = $theme;

        echo json_encode($data);
    }

    public function updateThemeSettings($params) {
      $content = trim(file_get_contents("php://input"));
      $decoded = json_decode($content, true);

      CSRF::checkTokenAjax($decoded['csrf_token']);

      Theme::updateThemeSettings($decoded['theme'], $params['params']['id']);
      file_put_contents(__DIR__  . '/../../../public/' . $decoded['theme']['name'] . '/css/customize.css', $decoded['theme']['css']);

      $typocss = '';

      $styles = json_decode($decoded['theme']['font_styles'], true);
      unset($styles['heading']);
      foreach($styles as $type => $style) {
          $typocss .= $type . '{';
          foreach($style as $prop => $value) {
              if($value) {
                if($prop === 'font_size') {
                    $value .= 'rem';
                }
                  $typocss .= str_replace('_', '-', $prop) . ':' . $value . ';';
              }
          }
          $typocss .= '}';
      }
      file_put_contents(__DIR__  . '/../../../public/' . $decoded['theme']['name'] . '/css/default/typography.css', $typocss);

      Theme::combineCSS($decoded['theme']['name']);
      Theme::combineJS($decoded['theme']['name']);


      header('Content-type: application/json');
      $data = [];
      $data['csrfToken'] = CSRF::getToken();

      echo json_encode($data);
    }

    public function store() {
        if(!self::checkPermission('add_theme')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        CSRF::checkToken();
        if(isset($_POST)) {
            $themePath = realpath(__DIR__ . '/../../Views/public/themes');
            mkdir($themePath . '/' . $_POST['theme']['name'], 0777, true);

            Theme::copyBaseTheme(__DIR__ . '/../../../Core/basetheme', $themePath . '/' . $_POST['theme']['name'], $_POST['theme']['name']);
            $theme = Theme::addTheme($_POST['theme']['name']);
            Theme::combineCSS($_POST['theme']['name']);
            Theme::combineJS($_POST['theme']['name']);

            self::redirect('/admin/themes/' . $theme['id'] . '/edit');
        }
    }

    public function updatedestroy($params) {
        CSRF::checkToken();
        if(isset($_POST)) {
            if($_POST['_METHOD'] === 'DELETE') {
                self::delete($params);
            } else if ($_POST['_METHOD'] === 'PUT') {
                self::update($params, $_POST);
            }
        }
    }

    public function update($params, $post) {
        if(!self::checkPermission('edit_theme')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        Theme::activateTheme($params['params']['id']);
        self::redirect('/admin/themes');
    }

    public function delete($params) {
        if(!self::checkPermission('delete_theme')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        if(Theme::getActiveTheme()['id'] !== $params['params']['id']) {
            $themePath = realpath(__DIR__ . '/../../Views/public/themes');
            Theme::deleteTheme($themePath . '/' . $params['params']['name'], $params['params']['name'], $params['params']['id']);
            self::redirect('/admin/themes');
        } else {
            self::addFlash('error', self::getTrans('You can not delete an active Theme!'));
            self::redirect('/admin/themes');
        }
    }
}