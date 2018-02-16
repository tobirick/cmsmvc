<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Menu;
use \Core\CSRF;

class MenusController extends BaseController {
    public function index() {
        $menus = Menu::getAllMenus();
        self::render('admin/menus/index', [
            'menus' => $menus
            ]);
    }

    public function edit($params) {
        $id = $params['params']['id'];
        $menu = Menu::getMenuById($id);
        $menuitems = Menu::getMenuItemsByMenuId($id);
        self::render('admin/menus/edit', [
            'menu' => $menu,
            'menuitems' => $menuitems
        ]);
    }

    public function create() {
        self::render('admin/menus/create');
    }

    public function store() {
        CSRF::checkToken();
        if(isset($_POST)) {
            $menu = new Menu();
            $menu->addMenu($_POST['menu']);
            self::redirect('/admin/menus');
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

    public function delete($params) {
        Menu::deleteMenu($params['params']['id']);
        self::redirect('/admin/menus');
    }

    public function update($params, $post) {
        Menu::updateMenu($params['params']['id'], $post['menu']);
        self::redirect('/admin/menus');
    }
}