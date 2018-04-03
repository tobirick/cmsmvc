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
            $stmt = $db->prepare('SELECT p.*, pc.* FROM pages as p INNER JOIN page_contents as pc ON
                                 pc.page_id = p.id WHERE pc.language_id = :language_id AND p.slug = :slug');
            $stmt->execute([
                ':slug' => $this->slug,
                ':language_id' => $languageID
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }
    }

    public static function getHomePage() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT pages.* FROM pages INNER JOIN config ON config.name = "home_page_id" AND config.value = pages.id');
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getAllPages($pageNumber = 1, $numberOfPagesPerPage = 9999) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT pages.*, users.name as author FROM pages LEFT JOIN users ON pages.created_by = users.id LIMIT :numberOfPagesPerPage OFFSET :offset');
        $stmt->bindValue(':numberOfPagesPerPage', $numberOfPagesPerPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $numberOfPagesPerPage * ($pageNumber - 1), \PDO::PARAM_INT);

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

    public function addPage($page, $userid) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pages (name, slug, title, created_at, created_by, is_active) VALUES(:name, :slug, :title, now(), :created_by, :is_active)');
        $stmt->execute([
            ':name' => $page['name'],
            ':slug' => $page['slug'],
            ':title' => $page['title'],
            ':created_by' => $userid,
            ':is_active' => 1
            ]);

        $lastID = $db->lastInsertId();
        return self::getPageById($lastID);
    }
    
    public static function updatePage($pageid, $page) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pages SET name = :name, slug = :slug, updated_at = now(), is_active = :is_active WHERE id = :id');
        $stmt->execute([
            ':id' => $pageid,
            ':name' => $page['name'],
            ':slug' => $page['slug'],
            ':is_active' => $page['is_active'] ? 1 : 0
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
}