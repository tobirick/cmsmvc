<?php

namespace App\Models;

use \Core\Model;
use PDO;

class Pagebuilder extends Model {
    public static function createItem($item) {
        $path = __DIR__ . '/../Views/admin/pagebuilder-items/' . $item['name'] . '.blade.php';

        self::createItemFolder($item);

        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_items (name, content, path_name, type, description) VALUES(:name, :content, :path_name, :type, :description)');
        $stmt->execute([
            ':name' => $item['name'],
            ':content' => $item['content'],
            ':type' => $item['type'],
            ':description' => $item['description'],
            ':path_name' => $path
            ]);

        return true;
    }

    public static function getAllItems() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_items');

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getItemById($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_items WHERE ID = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function updateItem($itemid, $item) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pagebuilder_items SET name = :name, content = :content WHERE id = :id');
        $stmt->execute([
            ':id' => $itemid,
            ':name' => $item['name'],
            ':content' => $item['content']
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function deleteItem($itemid) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM pagebuilder_items WHERE id = :id');
        $stmt->execute([
            ':id' => $itemid
        ]);

        return true;
    }

    public static function createItemFolder($item) {
        $path = __DIR__ . '/../Views/admin/pagebuilder-items/' . $item['name'] . '.blade.php';
        file_put_contents($path, $item['content']);
    }
}