<?php

namespace App\Models;

use \Core\Model;
use PDO;

class Pagebuilder extends Model {
    public static function createItem($item) {
        $path = __DIR__ . '/../Views/admin/pagebuilder-items/' . $item['name'] . '.blade.php';

        self::createItemFolder($item);

        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_items (item_name, item_content, item_path_name, item_type, item_description) VALUES(:name, :content, :path_name, :type, :description)');
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
        $stmt = $db->prepare('UPDATE pagebuilder_items SET item_name = :name, item_content = :content WHERE id = :id');
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

    public static function getElementByColumnID($columnID) {
      $db = static::getDB();
      $stmt = $db->prepare('SELECT * FROM pagebuilder_elements as pe INNER JOIN pagebuilder_items as pi ON pe.item_id = pi.id WHERE pe.column_id = :column_id ');
      $stmt->execute([
          ':column_id' => $columnID
      ]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result;
    }

    public static function saveSection($pageID, $section) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_sections (page_id, css_class, css_id, styles, name)
                              VALUES(:page_id, :css_class, :css_id, :styles, :name)');
        $stmt->execute([
            ':page_id' => $pageID,
            ':css_class' => $section['css_class'],
            ':css_id' => $section['css_id'],
            ':styles' => $section['styles'],
            ':name' => $section['name']
            ]);

        $lastID = $db->lastInsertId();
        return $lastID;
    }

    public static function saveRow($sectionID, $row) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_rows (section_id, css_class, css_id, styles, name)
                              VALUES(:section_id, :css_class, :css_id, :styles, :name)');
        $stmt->execute([
            ':section_id' => $sectionID,
            ':css_class' => $row['css_class'],
            ':css_id' => $row['css_id'],
            ':styles' => $row['styles'],
            ':name' => $row['name']
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

    public static function saveElement($columnID, $element) {
      $db = static::getDB();
      $stmt = $db->prepare('INSERT INTO pagebuilder_elements (column_id, item_id) VALUES(:column_id, :item_id)');
      $stmt->execute([
          ':column_id' => $columnID,
          ':item_id' => $element['item_id']
          ]);
   }

    public static function deleteSectionsByPageID($pageID) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM pagebuilder_sections WHERE page_id = :page_id');
        $stmt->execute([
            ':page_id' => $pageID
        ]);
    }
}