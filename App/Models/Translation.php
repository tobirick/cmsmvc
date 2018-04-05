<?php

namespace App\Models;

use \Core\Model;
use PDO;

class Translation extends Model {

  public static function getAllTranslations() {
    $sql = 'SELECT * FROM translations ORDER BY id DESC';
    
    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function addTranslation($languageID, $translation) {
    $sql = 'INSERT INTO translations SET `key` = :key, language_id = :language_id, value = :value';
    
    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':key' => $translation['key'],
        ':language_id' => $languageID,
        ':value' => ''
    ]);

    $lastID = $db->lastInsertId();
    return self::getTranslationByID($lastID);
  }

  public static function updateTranslationByID($id, $translation) {
    $db = static::getDB();
    $stmt = $db->prepare('UPDATE translations SET value = :value WHERE id = :id');
    $stmt->execute([
        ':id' => $id,
        ':value' => $translation['value']
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
  }

  public static function getTranslationByID($id) {
    $sql = 'SELECT * FROM translations WHERE id = :id';
    
    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':id' => $id
    ]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public static function deleteTranslationByID($id) {
    $db = static::getDB();
    $stmt = $db->prepare('DELETE FROM translations WHERE id = :id');
    $stmt->execute([
        ':id' => $id
    ]);
  }

  public static function getTranslationByKey($key) {
    $sql = 'SELECT value FROM translations WHERE `key` = :key';
    
    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':key' => $key
    ]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}