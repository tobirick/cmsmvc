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

    public function getPageBySlug() {
        if($this->slug) {
            $db = static::getDB();
            $stmt = $db->prepare('SELECT * FROM pages WHERE slug = :slug');
            $stmt->execute([
                ':slug' => $this->slug
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }
    }

    public static function getHomePage() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pages INNER JOIN config ON config.name = "home_page_id" AND config.value = pages.id');
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getAllPages($pageNumber = 1, $numberOfPagesPerPage = 9999) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pages LIMIT :numberOfPagesPerPage OFFSET :offset');
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

    public function addPage($page) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pages (name, slug, title, created_at) VALUES(:name, :slug, :title, now())');
        $stmt->execute([
            ':name' => $page['name'],
            ':slug' => $page['slug'],
            ':title' => $page['title']
            ]);

        $lastID = $db->lastInsertId();
        return self::getPageById($lastID);
    }
    
    public static function updatePage($pageid, $page) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pages SET name = :name, slug = :slug, title = :title, seo_title = :seo_title, seo_description = :seo_description, updated_at = now() WHERE id = :id');
        $stmt->execute([
            ':id' => $pageid,
            ':name' => $page['name'],
            ':slug' => $page['slug'],
            ':title' => $page['title'],
            ':seo_title' => $page['seo_title'],
            ':seo_description' => $page['seo_description']
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
}