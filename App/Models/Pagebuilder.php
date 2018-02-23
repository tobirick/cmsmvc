<?php

namespace App\Models;

use \Core\Model;
use PDO;

class Pagebuilder extends Model {
    public static function createItem($item) {
        $path = __DIR__ . '/../Views/admin/pagebuilder-items/' . $item['name'] . '.blade.php';

        self::createItemFolder($item);

        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_items (name, content, path_name) VALUES(:name, :content, :path_name)');
        $stmt->execute([
            ':name' => $item['name'],
            ':content' => $item['content'],
            ':path_name' => $path
            ]);

        return true;
    }

    public static function createItemFolder($item) {
        $path = __DIR__ . '/../Views/admin/pagebuilder-items/' . $item['name'] . '.blade.php';
        file_put_contents($path, $item['content']);
    }
}