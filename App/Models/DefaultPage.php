<?php

namespace App\Models;

use \Core\Model;
use PDO;

class DefaultPage extends Model {
    public function __construct($data = []) {
        if(!empty($data)) {
            foreach($data as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function validate() {
        $errors = [];
        if($this->name === '') {
            $errors[] = 'Name is required';
        }

        if($this->slug === '') {
            $errors[] = 'Slug is required';
        }

        return $errors;
    }

    public static function setEditStatus($id, $status) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pages SET in_edit = :status WHERE id = :id');
        $stmt->execute([
            ':id' => $id,
            ':status' => $status
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getEditStatus($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT in_edit FROM pages WHERE ID = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $status = (int)$result['in_edit'];

        return $status;
    }

    public static function getPageById($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pages WHERE ID = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getPageBySlug($languageID) {
        if($this->slug) {
            $db = static::getDB();
            $stmt = $db->prepare('SELECT p.*, pc.content, pc.title, pc.seo_title, pc.seo_description, pc.slug FROM pages as p INNER JOIN page_contents as pc ON
                                 pc.page_id = p.id WHERE pc.language_id = :language_id AND pc.slug = :slug');
            $stmt->execute([
                ':slug' => $this->slug,
                ':language_id' => $languageID
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);


            return $result;
        }
    }

    public static function getHomePage($langID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT pages.*, pc.slug FROM pages INNER JOIN config ON config.name = "home_page_id" AND config.value = pages.id INNER JOIN page_contents as pc ON pc.page_id = pages.id WHERE pc.language_id = :language_id');
        $stmt->execute([
                ':language_id' => $langID
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getAllPages($pageNumber = 1, $numberOfPagesPerPage = 9999, $langID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT pages.*, users.name as author, pc.slug FROM pages LEFT JOIN users ON pages.created_by = users.id INNER JOIN page_contents as pc ON pc.page_id = pages.id AND pc.language_id = :language_id LIMIT :numberOfPagesPerPage OFFSET :offset');
        $stmt->bindValue(':numberOfPagesPerPage', $numberOfPagesPerPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $numberOfPagesPerPage * ($pageNumber - 1), \PDO::PARAM_INT);
        $stmt->bindValue(':language_id', $langID, \PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function countPages() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT COUNT(*) as numberofpages FROM pages');

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['numberofpages'];
    }

    public function savePage($userid) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pages (name, created_at, created_by, is_active, white_logo_active) VALUES(:name, now(), :created_by, :is_active, :white_logo_active)');
        $stmt->execute([
            ':name' => $this->name,
            ':created_by' => $userid,
            ':is_active' => 1,
            ':white_logo_active' => 0
            ]);

        $lastID = $db->lastInsertId();
        return self::getPageById($lastID);
    }
    
    public static function updatePage($pageid, $page) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pages SET name = :name, updated_at = now(), is_active = :is_active, white_logo_active = :white_logo_active WHERE id = :id');
        $stmt->execute([
            ':id' => $pageid,
            ':name' => $page['name'],
            ':is_active' => $page['is_active'] ? 1 : 0,
            ':white_logo_active' => $page['white_logo_active'] ? 1 : 0
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function deletePage($pageid) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM pages WHERE id = :id');
        $stmt->execute([
            ':id' => $pageid
        ]);

        return true;
    }

    public static function getPageContentsByID($pageID, $langID) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM page_contents WHERE page_id = :page_id AND language_id = :language_id');
        $stmt->execute([
            ':page_id' => $pageID,
            ':language_id' => $langID
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function addPageContents($pageID, $langID, $slug) {
      $db = static::getDB();
      $stmt = $db->prepare('INSERT INTO page_contents SET page_id = :page_id, language_id = :language_id, slug = :slug');
      $stmt->execute([
          ':page_id' => $pageID,
          ':language_id' => $langID,
          ':slug' => $slug
          ]);
    }
}