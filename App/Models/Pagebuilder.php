<?php

namespace App\Models;

use \Core\Model;
use PDO;

class Pagebuilder extends Model {
    public static function createItem($item) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_items (item_name, item_html, item_type, item_json_config) VALUES(:name, :html, :type, :config)');
        $stmt->execute([
            ':name' => $item['name'],
            ':html' => $item['html'],
            ':type' => $item['type'],
            ':config' => $item['config']
            ]);

        $lastID = $db->lastInsertId();
        return self::getItemById($lastID);
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

    public static function updateItem($itemid, $item) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pagebuilder_items SET item_name = :name, item_html = :html, item_type = :type, item_json_config = :config WHERE id = :id');
        $stmt->execute([
            ':id' => $itemid,
            ':name' => $item['name'],
            ':html' => $item['html'],
            ':type' => $item['type'],
            ':config' => $item['config']
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

    public static function getSectionsByPageID($pageID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_sections WHERE page_id = :page_id ORDER BY position');
        $stmt->execute([
            ':page_id' => $pageID
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getRowsBySectionID($sectionID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_rows WHERE section_id = :section_id ORDER BY position');
        $stmt->execute([
            ':section_id' => $sectionID
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getColumnRowsByRowID($rowID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_columnrows WHERE row_id = :row_id ORDER BY position');
        $stmt->execute([
            ':row_id' => $rowID
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getColumnsByColumnRowID($columnRowID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_columns WHERE columnrow_id = :columnrow_id ORDER BY position');
        $stmt->execute([
            ':columnrow_id' => $columnRowID
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getElementByColumnID($columnID) {
      $db = static::getDB();
      $stmt = $db->prepare('SELECT pe.*, pi.item_name, pi.item_type, pi.item_html, pi.item_json_config FROM pagebuilder_elements as pe INNER JOIN pagebuilder_items as pi ON pe.item_id = pi.id WHERE pe.column_id = :column_id ');
      $stmt->execute([
          ':column_id' => $columnID
      ]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result;
    }

    public static function saveSection($pageID, $section, $position) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_sections (page_id, css_class, css_id, styles, name, bg_color, bg_image, bg_image_size, bg_image_position, bg_image_repeat, padding, margin, current_bg_mode,
                            bg_gradient_first_color, bg_gradient_second_color, bg_gradient_type, bg_gradient_direction, bg_gradient_start_position, bg_gradient_end_position,
                            language_id, full_width, position)
                              VALUES(:page_id, :css_class, :css_id, :styles, :name, :bg_color, :bg_image, :bg_image_size, :bg_image_position, :bg_image_repeat, :padding, :margin, :current_bg_mode,
                              :bg_gradient_first_color, :bg_gradient_second_color, :bg_gradient_type, :bg_gradient_direction, :bg_gradient_start_position, :bg_gradient_end_position,
                              :language_id, :full_width, :position)');
        $stmt->execute([
            ':page_id' => $pageID,
            ':css_class' => $section['css_class'],
            ':css_id' => $section['css_id'],
            ':styles' => $section['styles'],
            ':name' => $section['name'],
            ':bg_color' => $section['bg_color'],
            ':bg_image' => $section['bg_image'],
            ':bg_image_size' => $section['bg_image_size'],
            ':bg_image_position' => $section['bg_image_position'],
            ':bg_image_repeat' => $section['bg_image_repeat'],
            ':padding' => $section['padding'],
            ':margin' => $section['margin'],
            ':current_bg_mode' => $section['current_bg_mode'],
            ':bg_gradient_first_color' => $section['bg_gradient_first_color'],
            ':bg_gradient_second_color' => $section['bg_gradient_second_color'],
            ':bg_gradient_type' => $section['bg_gradient_type'],
            ':bg_gradient_direction' => $section['bg_gradient_direction'],
            ':bg_gradient_start_position' => $section['bg_gradient_start_position'],
            ':bg_gradient_end_position' => $section['bg_gradient_end_position'],
            ':language_id' => $section['language_id'],
            ':full_width' => $section['full_width'],
            ':position' => $position
            ]);

        $lastID = $db->lastInsertId();
        return $lastID;
    }

    public static function updateSection($section, $position) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pagebuilder_sections SET css_class = :css_class, css_id = :css_id, styles = :styles, name = :name, bg_color = :bg_color, bg_image = :bg_image,
                            bg_image_size = :bg_image_size, bg_image_position = :bg_image_position, bg_image_repeat = :bg_image_repeat, padding = :padding, margin = :margin, current_bg_mode = :current_bg_mode,
                            bg_gradient_first_color = :bg_gradient_first_color, bg_gradient_second_color = :bg_gradient_second_color, bg_gradient_type = :bg_gradient_type, bg_gradient_direction = :bg_gradient_direction,
                            bg_gradient_start_position = :bg_gradient_start_position, bg_gradient_end_position = :bg_gradient_end_position, language_id = :language_id, full_width = :full_width, position = :position
                            WHERE id = :id');

        $stmt->execute([
            ':css_class' => $section['css_class'],
            ':css_id' => $section['css_id'],
            ':styles' => $section['styles'],
            ':name' => $section['name'],
            ':bg_color' => $section['bg_color'],
            ':bg_image' => $section['bg_image'],
            ':bg_image_size' => $section['bg_image_size'],
            ':bg_image_position' => $section['bg_image_position'],
            ':bg_image_repeat' => $section['bg_image_repeat'],
            ':padding' => $section['padding'],
            ':margin' => $section['margin'],
            ':current_bg_mode' => $section['current_bg_mode'],
            ':bg_gradient_first_color' => $section['bg_gradient_first_color'],
            ':bg_gradient_second_color' => $section['bg_gradient_second_color'],
            ':bg_gradient_type' => $section['bg_gradient_type'],
            ':bg_gradient_direction' => $section['bg_gradient_direction'],
            ':bg_gradient_start_position' => $section['bg_gradient_start_position'],
            ':bg_gradient_end_position' => $section['bg_gradient_end_position'],
            ':language_id' => $section['language_id'],
            ':full_width' => $section['full_width'],
            ':id' => $section['id'],
            ':position' => $position
            ]);

        return $stmt;
    }

    public static function saveRow($sectionID, $row, $position) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_rows (section_id, css_class, css_id, styles, name, bg_color, bg_image, bg_image_size, bg_image_position, bg_image_repeat, padding, margin, current_bg_mode,
                                bg_gradient_first_color, bg_gradient_second_color, bg_gradient_type, bg_gradient_direction, bg_gradient_start_position, bg_gradient_end_position, position)
                              VALUES(:section_id, :css_class, :css_id, :styles, :name, :bg_color, :bg_image, :bg_image_size, :bg_image_position, :bg_image_repeat, :padding, :margin, :current_bg_mode,
                              :bg_gradient_first_color, :bg_gradient_second_color, :bg_gradient_type, :bg_gradient_direction, :bg_gradient_start_position, :bg_gradient_end_position, :position)');
        $stmt->execute([
            ':section_id' => $sectionID,
            ':css_class' => $row['css_class'],
            ':css_id' => $row['css_id'],
            ':styles' => $row['styles'],
            ':name' => $row['name'],
            ':bg_color' => $row['bg_color'],
            ':bg_image_size' => $row['bg_image_size'],
            ':bg_image_position' => $row['bg_image_position'],
            ':bg_image_repeat' => $row['bg_image_repeat'],
            ':bg_image' => $row['bg_image'],
            ':padding' => $row['padding'],
            ':margin' => $row['margin'],
            ':current_bg_mode' => $row['current_bg_mode'],
            ':bg_gradient_first_color' => $row['bg_gradient_first_color'],
            ':bg_gradient_second_color' => $row['bg_gradient_second_color'],
            ':bg_gradient_type' => $row['bg_gradient_type'],
            ':bg_gradient_direction' => $row['bg_gradient_direction'],
            ':bg_gradient_start_position' => $row['bg_gradient_start_position'],
            ':bg_gradient_end_position' => $row['bg_gradient_end_position'],
            ':position' => $position
            ]);

        $lastID = $db->lastInsertId();
        return $lastID;
    }

    public static function updateRow($sectionID, $row, $position) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pagebuilder_rows SET section_id = :section_id, css_class = :css_class, css_id = :css_id, styles = :styles, name = :name, bg_color = :bg_color, bg_image = :bg_image,
                                bg_image_size = :bg_image_size, bg_image_position = :bg_image_position, bg_image_repeat = :bg_image_repeat, padding = :padding, margin = :margin, current_bg_mode = :current_bg_mode,
                                bg_gradient_first_color = :bg_gradient_first_color, bg_gradient_second_color = :bg_gradient_second_color, bg_gradient_type = :bg_gradient_type, bg_gradient_direction = :bg_gradient_direction,
                                 bg_gradient_start_position = :bg_gradient_start_position, bg_gradient_end_position = :bg_gradient_end_position, position = :position WHERE id = :id');
        $stmt->execute([
            ':section_id' => $sectionID,
            ':css_class' => $row['css_class'],
            ':css_id' => $row['css_id'],
            ':styles' => $row['styles'],
            ':name' => $row['name'],
            ':bg_color' => $row['bg_color'],
            ':bg_image_size' => $row['bg_image_size'],
            ':bg_image_position' => $row['bg_image_position'],
            ':bg_image_repeat' => $row['bg_image_repeat'],
            ':bg_image' => $row['bg_image'],
            ':padding' => $row['padding'],
            ':margin' => $row['margin'],
            ':current_bg_mode' => $row['current_bg_mode'],
            ':bg_gradient_first_color' => $row['bg_gradient_first_color'],
            ':bg_gradient_second_color' => $row['bg_gradient_second_color'],
            ':bg_gradient_type' => $row['bg_gradient_type'],
            ':bg_gradient_direction' => $row['bg_gradient_direction'],
            ':bg_gradient_start_position' => $row['bg_gradient_start_position'],
            ':bg_gradient_end_position' => $row['bg_gradient_end_position'],
            ':id' => $row['id'],
            ':position' => $position
            ]);

        return $stmt;
    }

    public static function saveColumnRow($rowID, $columnrow, $position) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_columnrows (row_id, position) VALUES(:row_id, :position)');
        $stmt->execute([
            ':row_id' => $rowID,
            ':position' => $position
            ]);

        $lastID = $db->lastInsertId();
        return $lastID;
    }

    public static function updateColumnRow($rowID, $columnrow, $position) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pagebuilder_columnrows SET row_id = :row_id, position = :position WHERE id = :id');
        $stmt->execute([
            ':row_id' => $rowID,
            ':id' => $columnrow['id'],
            ':position' => $position
            ]);

        return $stmt;
    }

    public static function saveColumn($columnRowID, $column, $position) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pagebuilder_columns (columnrow_id, col, position) VALUES(:columnrow_id, :col, :position)');
        $stmt->execute([
            ':columnrow_id' => $columnRowID,
            ':col' => $column['col'],
            ':position' => $position
            ]);

        $lastID = $db->lastInsertId();
        return $lastID;
   }

   public static function updateColumn($columnRowID, $column, $position) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pagebuilder_columns SET columnrow_id = :columnrow_id, col = :col, position = :position WHERE id = :id');
        $stmt->execute([
            ':columnrow_id' => $columnRowID,
            ':col' => $column['col'],
            ':id' => $column['id'],
            ':position' => $position
            ]);

        return $stmt;
   }

    public static function saveElement($columnID, $element) {
      $db = static::getDB();
      $stmt = $db->prepare('INSERT INTO pagebuilder_elements (column_id, item_id, css_class, css_id, styles, name, bg_color, padding, margin, html, config)
                            VALUES(:column_id, :item_id, :css_class, :css_id, :styles, :name, :bg_color, :padding, :margin, :html, :config)');
      $stmt->execute([
          ':column_id' => $columnID,
          ':item_id' => $element['item_id'],
          ':css_class' => $element['css_class'],
          ':css_id' => $element['css_id'],
          ':styles' => $element['styles'],
          ':name' => $element['name'],
          ':bg_color' => $element['bg_color'],
          ':padding' => $element['padding'],
          ':margin' => $element['margin'],
          ':html' => $element['html'],
          ':config' => json_encode($element['config'])
          ]);
   }

   public static function updateElement($columnID, $element) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pagebuilder_elements SET column_id = :column_id, item_id = :item_id, css_class = :css_class, css_id = :css_id, styles = :styles, name = :name, bg_color = :bg_color,
                             padding = :padding, margin = :margin, html = :html, config = :config WHERE id = :id');
        $stmt->execute([
            ':column_id' => $columnID,
            ':item_id' => $element['item_id'],
            ':css_class' => $element['css_class'],
            ':css_id' => $element['css_id'],
            ':styles' => $element['styles'],
            ':name' => $element['name'],
            ':bg_color' => $element['bg_color'],
            ':padding' => $element['padding'],
            ':margin' => $element['margin'],
            ':html' => $element['html'],
            ':config' => json_encode($element['config']),
            ':id' => $element['id']
            ]);

        return $stmt;
   }

    public static function deleteSectionsByPageID($pageID) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM pagebuilder_sections WHERE page_id = :page_id');
        $stmt->execute([
            ':page_id' => $pageID
        ]);
    }

    public static function deleteSectionByID($id) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM pagebuilder_sections WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public static function deleteRowByID($id) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM pagebuilder_rows WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public static function deleteColumnByID($id) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM pagebuilder_columns WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public static function deleteElementByID($id) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM pagebuilder_elements WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public static function deletePageContentsByPageID($pageID) {
      $db = static::getDB();
      $stmt = $db->prepare('DELETE FROM page_contents WHERE page_id = :page_id');
      $stmt->execute([
          ':page_id' => $pageID
      ]);
    }

    public static function saveHTMLToPage($pageid, $html) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pages SET content = :content WHERE id = :id');
        $stmt->execute([
            ':content' => $html,
            ':id' => $pageid
            ]);

        return true;
    }

    public static function saveToPageContent($pageID, $languageID, $html, $page) {
      $db = static::getDB();
      $stmt = $db->prepare('INSERT INTO page_contents SET page_id = :page_id, language_id = :language_id, content = :content, title = :title, seo_title = :seo_title, seo_description = :seo_description, slug = :slug');
      $stmt->execute([
          ':content' => $html,
          ':title' => $page['title'],
          ':seo_title' => $page['seo_title'],
          ':seo_description' => $page['seo_description'],
          ':slug' => $page['slug'],
          ':page_id' => $pageID,
          ':language_id' => $languageID
          ]);

      return true;
    }

    public static function updatePageContent($pageID, $languageID, $html, $page) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE page_contents SET content = :content, title = :title, seo_title = :seo_title, seo_description = :seo_description, slug = :slug WHERE page_id = :page_id AND language_id = :language_id');
        $stmt->execute([
            ':content' => $html,
            ':title' => $page['title'],
            ':seo_title' => $page['seo_title'],
            ':seo_description' => $page['seo_description'],
            ':slug' => $page['slug'],
            ':page_id' => $pageID,
            ':language_id' => $languageID
            ]);
  
        return true;
    }

    public static function checkIfSectionExists($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_sections WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function checkIfRowExists($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_rows WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function checkIfColumnRowExists($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_columnrows WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function checkIfColumnExists($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_columns WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function checkIfElementExists($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pagebuilder_elements WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}