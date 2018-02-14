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

    public function edit() {
        self::render('admin/themes/edit');
    }

    public function create() {
        self::render('admin/themes/create');
    }

    public function store() {
        CSRF::checkToken();
        if(isset($_POST)) {
            $themePath = realpath(__DIR__ . '/../../Views/public/themes');
            mkdir($themePath . '/' . $_POST['theme']['name'], 0777, true);

            Theme::copyBaseTheme(__DIR__ . '/../../../Core/basetheme', $themePath . '/' . $_POST['theme']['name'], $_POST['theme']['name']);
            Theme::addTheme($_POST['theme']['name']);

            self::redirect('/admin/themes');
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
        Theme::activateTheme($params['params']['id']);
        self::redirect('/admin/themes');
    }

    public function delete($params) {
        $themePath = realpath(__DIR__ . '/../../Views/public/themes');
        Theme::deleteTheme($themePath . '/' . $params['params']['name'], $params['params']['name'], $params['params']['id']);
        self::redirect('/admin/themes');
    }
}