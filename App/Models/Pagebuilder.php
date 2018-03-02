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

    public static function getSectionsByPageID($pageID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_sections WHERE page_id = :page_id');
        $stmt->execute([
            ':page_id' => $pageID
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getRowsBySectionID($sectionID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_rows WHERE section_id = :section_id');
        $stmt->execute([
            ':section_id' => $sectionID
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getColumnRowsByRowID($rowID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_columnrows WHERE row_id = :row_id');
        $stmt->execute([
            ':row_id' => $rowID
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getColumnsByColumnRowID($columnRowID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_columns WHERE columnrow_id = :columnrow_id');
        $stmt->execute([
            ':columnrow_id' => $columnRowID
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function saveSection($pageID, $section) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_sections (page_id) VALUES(:page_id)');
        $stmt->execute([
            ':page_id' => $pageID
            ]);

        $lastID = $db->lastInsertId();
        return $lastID;
    }

    public static function saveRow($sectionID, $row) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_rows (section_id) VALUES(:section_id)');
        $stmt->execute([
            ':section_id' => $sectionID
            ]);

        $lastID = $db->lastInsertId();
        return $lastID;
    }

    public static function saveColumnRow($rowID, $columnrow) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_columnrows (row_id) VALUES(:row_id)');
        $stmt->execute([
            ':row_id' => $rowID
            ]);

        $lastID = $db->lastInsertId();
        return $lastID;
    }

    public static function saveColumn($columnRowID, $column) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_columns (columnrow_id, col) VALUES(:columnrow_id, :col)');
        $stmt->execute([
            ':columnrow_id' => $columnRowID,
            ':col' => $column['col']
            ]);

        $lastID = $db->lastInsertId();
        return $lastID;
    }

    public static function deleteSectionsByPageID($pageID) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM pagebuilder_sections WHERE page_id = :page_id');
        $stmt->execute([
            ':page_id' => $pageID
        ]);
    }
}