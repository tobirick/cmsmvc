<?php
namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Menu;
use \Core\CSRF;

class MenuItemsController extends BaseController {
    public function store($params) {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);
        if(!self::checkPermission('edit_menu')) {         
            $data['error'] = self::getTrans('You have not the permission to do that!');
        } else {
            $listItem = Menu::addMenuItem($params['params']['id'], $decoded['menuitem']);
            $data['listItem'] = $listItem;
        }

        header('Content-type: application/json');
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }

    public function getAllListItems($params) {
        header('Content-type: application/json');
        if(!self::checkPermission('view_menu')) {         
            $data['error'] = self::getTrans('You have not the permission to do that!');
            echo json_encode($data);
        } else {
            $listItems = Menu::getMenuItemsByMenuId($params['params']['id']);
            foreach($listItems as $key => $listItem) {
                $subListItems = Menu::getSubListItemsByListItemId($listItem['id']);
                $listItems[$key]['subListItems'] = $subListItems;
            }
            echo json_encode($listItems);
        }

    }

    public function updatedestroy($params) {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);
        if($decoded['_METHOD'] === 'DELETE') {
            self::destroy($params);
        } else if ($decoded['_METHOD'] === 'PUT') {
            self::update($params, $decoded);
        }
    }

    public function update($params, $post) {
        if(!self::checkPermission('edit_menu')) {         
            $data['error'] = self::getTrans('You have not the permission to do that!');
        } else {
            Menu::updateMenuItem($params['params']['menuitemid'], $post['menuitem']);
        }
        
        header('Content-type: application/json');
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }

    public function destroy($params) {
        if(!self::checkPermission('delete_menu')) {         
            $data['error'] = self::getTrans('You have not the permission to do that!');
        } else {
            Menu::deleteMenuItem($params['params']['menuitemid']);
        }
        header('Content-type: application/json');
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }

    public function updatePosition($params) {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);

        if(!self::checkPermission('edit_menu')) {         
            $data['error'] = self::getTrans('You have not the permission to do that!');
        } else {
            foreach($decoded['menuitems'] as $menuitem) {
                $menuitem['parent_id'] = NULL;
                if(sizeof($menuitem['subListItems']) > 0) {
                    foreach($menuitem['subListItems'] as $submenuitem) {
                        $submenuitem['parent_id'] = $menuitem['id'];
                        Menu::updateMenuItemPosition($submenuitem);
                    }
                }
                Menu::updateMenuItemPosition($menuitem);
            }
        }
        
        header('Content-type: application/json');
        $data['csrfToken'] = CSRF::getToken();
        echo json_encode($data);
    }
}