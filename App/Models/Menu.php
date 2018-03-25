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

    public static function addMenu($menu) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO menus (name) VALUES(:name)');
        $stmt->execute([
            ':name' => $menu['name']
            ]);

         $lastID = $db->lastInsertId();
         return self::getMenuById($lastID);
    }

    public static function getAllMenuTypeNames() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT name, value FROM config WHERE name LIKE "%menu%"');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $types = array();
        foreach($result as $r) {
            $types[$r['name']] = [
                'name' => $r['name'],
                'value' => $r['value'],
            ];
        }

        return $types;
    }
    
    public static function updateMenu($menuid, $menu) {
        $arraykeys = array_keys($menu);

        $selectedMenutypes = array();
        $menutypesFromDB = self::getAllMenuTypeNames();

        foreach ($arraykeys as $arraykey) {
            if(strpos($arraykey, 'menu')) {
                $selectedMenutypes[] = $arraykey;
            }
        }

        // Set all menu types from this menu inactive
        foreach($menutypesFromDB as $menutype) {
            if($menuid === $menutype['value']) {
                self::unsetActiveMenu($menutype['name']);
            }
        }

        // set selected menu types as active menu
        foreach($selectedMenutypes as $menutype) {
            self::setActiveMenu($menu, $menutype);
        }

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
        $stmt = $db->prepare('SELECT * FROM menu_items WHERE menu_id = :menu_id ORDER BY menu_position');
        $stmt->execute([
            ':menu_id' => $menuid
        ]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function addMenuItem($menuid, $menuitem) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO menu_items (name, menu_id, page_id, menu_position) VALUES(:name, :menu_id, :page_id, :menu_position)');
        $stmt->execute([
            ':name' => $menuitem['name'],
            ':menu_id' => $menuid,
            ':page_id' => $menuitem['page_id'],
            ':menu_position' => $menuitem['menu_position']
        ]);

        $lastID = $db->lastInsertId();
        return self::getListItemByID($lastID);
    }

    public static function getListItemByID($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM menu_items WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
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

    public static function updateMenuItemPosition($menuitem) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE menu_items SET menu_position = :menu_position WHERE id = :id');
        $stmt->execute([
            ':menu_position' => $menuitem['menu_position'],
            ':id' => $menuitem['id']
        ]);

        return true;
    }

    public static function setActiveMenu($menu, $menutype) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE CONFIG SET value = :value WHERE name = :name');
        $stmt->execute([
            ':name' => $menutype,
            ':value' => $menu[$menutype]
        ]);

        return true;
    }

    public static function unsetActiveMenu($menutype) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE CONFIG SET value = "" WHERE name = :name');
        $stmt->execute([
            ':name' => $menutype
        ]);

        return true;
    }

    public static function getActiveMenuID() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM config WHERE name = :name');
        $stmt->execute([
            ':name' => 'active_menu_id'
        ]);
        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        return $id;
    }

    public static function getActiveMenu() {
        $id = self::getActiveMenuID()['value'];

        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM menus WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getActiveMenuPages() {
        $id = self::getActiveMenuID()['value'];

        $db = static::getDB();
        $stmt = $db->prepare('SELECT mi.name, p.slug FROM menu_items as mi INNER JOIN pages as p ON p.id = mi.page_id WHERE menu_id = :id ORDER BY mi.menu_position');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}