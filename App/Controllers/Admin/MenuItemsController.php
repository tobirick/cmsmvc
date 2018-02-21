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
        $listItem = Menu::addMenuItem($params['params']['id'], $decoded['menuitem']);

        header('Content-type: application/json');
        $data = [];
        $data['listItem'] = $listItem;
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }

    public function getAllListItems($params) {
        $listItems = Menu::getMenuItemsByMenuId($params['params']['id']);

        header('Content-type: application/json');
        echo json_encode($listItems);
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
        Menu::updateMenuItem($params['params']['menuitemid'], $post['menuitem']);
        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }

    public function destroy($params) {
        Menu::deleteMenuItem($params['params']['menuitemid']);
        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }
}