<?php

namespace App\Models;

use \Core\Model;
use PDO;

class DefaultPost extends Model {
    public function __construct($data) {
        foreach($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getPostBySlug() {
        if($this->slug) {
            $db = static::getDB();
            $stmt = $db->prepare('SELECT * from posts WHERE slug = :slug');
            $stmt->execute([
                ':slug' => $this->slug
            ]);
            // TODO: Find Page by slug in database
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function getAllPosts() {
        // TODO: Return all pages with slug
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM posts');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
}