<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Menu;
use \Core\CSRF;

class MenuItemsController extends BaseController {
    public function store($params) {
        CSRF::checkToken();
        if(isset($_POST)) {
            Menu::addMenuItem($params['params']['id'], $_POST['menuitem']);
            self::redirect('/admin/menus/' . $params['params']['id'] . '/edit');
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
        Menu::updateMenuItem($params['params']['menuitemid'], $post['menuitem']);
        self::redirect('/admin/menus/' . $params['params']['id'] . '/edit');
    }

    public function destroy($params) {
        Menu::deleteMenuItem($params['params']['menuitemid']);
        self::redirect('/admin/menus/' . $params['params']['id'] . '/edit');
    }
}