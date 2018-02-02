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

    public static function getAllPages() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM pages');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function addPage($page) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO pages (name, content, slug, title) VALUES(:name, :content, :slug, :title)');
        $stmt->execute([
            ':name' => $page['name'],
            ':content' => $page['content'],
            ':slug' => $page['slug'],
            ':title' => $page['title'],
            ]);

        return true;
    }
    
    public function updatePage($pageid, $page) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE pages SET name = :name, content = :content, slug = :slug, title = :title WHERE id = :id');
        $stmt->execute([
            ':id' => $pageid,
            ':name' => $page['name'],
            ':content' => $page['content'],
            ':slug' => $page['slug'],
            ':title' => $page['title']
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