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
        if(!self::checkPermission('edit_menu')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }

        $id = $params['params']['id'];
        $menu = Menu::getMenuById($id);
        $menuitems = Menu::getMenuItemsByMenuId($id);
        if($menu) {
           self::render('admin/menus/edit', [
               'menu' => $menu,
               'menuitems' => $menuitems
           ]);
        } else {
         self::render('error/404');
         }
    }

    public function create() {
        if(!self::checkPermission('add_menu')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        self::render('admin/menus/create');
    }

    public function store() {
        if(!self::checkPermission('add_menu')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        CSRF::checkToken();
        if(isset($_POST)) {
            $menu = new Menu();
            $newMenu = $menu->addMenu($_POST['menu']);
            self::redirect('/admin/menus/' . $newMenu['id'] . '/edit');
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
        if(!self::checkPermission('delete_menu')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        Menu::deleteMenu($params['params']['id']);
        self::redirect('/admin/menus');
    }

    public function update($params, $post) {
        if(!self::checkPermission('edit_menu')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        Menu::updateMenu($params['params']['id'], $post['menu']);
        self::redirect('/admin/menus');
    }
}