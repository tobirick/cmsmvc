<?php

namespace App\Models;

use \Core\Model;
use PDO;

class Menu extends Model {
    public function __construct($data = []) {
        if(!empty($data)) {
            foreach($data as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public static function getMenuById($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM menus WHERE ID = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getAllMenus() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM menus');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function addMenu($menu) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO menus (name) VALUES(:name)');
        $stmt->execute([
            ':name' => $menu['name']
            ]);

        return true;
    }
    
    public function updateMenu($menuid, $menu) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE menus SET name = :name WHERE id = :id');
        $stmt->execute([
            ':id' => $menuid,
            ':name' => $menu['name']
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function deleteMenu($menuid) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM menus WHERE id = :id');
        $stmt->execute([
            ':id' => $menuid
        ]);

        return true;
    }

    public static function getMenuItemsByMenuId($menuid) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM menu_items WHERE menu_id = :menu_id');
        $stmt->execute([
            ':menu_id' => $menuid
        ]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function addMenuItem($menuid, $menuitem) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO menu_items (name, menu_id, page_id) VALUES(:name, :menu_id, :page_id)');
        $stmt->execute([
            ':name' => $menuitem['name'],
            ':menu_id' => $menuid,
            ':page_id' => $menuitem['page']
        ]);

        return true;
    }

    public static function deleteMenuItem($menuitemid) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM menu_items WHERE id = :id');
        $stmt->execute([
            ':id' => $menuitemid
        ]);

        return true;
    }

    public static function updateMenuItem($menuitemid, $menuitem) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE menu_items SET name = :name, page_id = :page_id WHERE id = :id');
        $stmt->execute([
            ':name' => $menuitem['name'],
            ':page_id' => $menuitem['page'],
            ':id' => $menuitemid
        ]);

        return true;
    }
}