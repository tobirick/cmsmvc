<?php

namespace App\Models;

use \Core\Model;
use PDO;

class Language extends Model {
    public static function validate($theme) {
        $errors = [];
        
        if($theme['name'] === '') {
            $errors[] = 'Name is required';
        }

        if($theme['iso'] === '') {
            $errors[] = 'ISO is required';
        }

        return $errors;
    }

   public static function addLanguage($language) {
      $db = static::getDB();
      $stmt = $db->prepare('INSERT INTO languages (name, iso) VALUES(:name, :iso)');
      $stmt->execute([
          ':name' => $language['name'],
          ':iso' => $language['iso']
      ]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $lastID = $db->lastInsertId();
      return self::getLanguageById($lastID);
   }

   public static function updateLanguage($id, $language) {
      $db = static::getDB();
      $stmt = $db->prepare('UPDATE languages SET name = :name, iso = :iso WHERE id = :id');
      $stmt->execute([
          ':name' => $language['name'],
          ':iso' => $language['iso'],
          ':id' => $id
      ]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result;
   }

   public static function deleteLanguage($id) {
      $db = static::getDB();
      $stmt = $db->prepare('DELETE FROM languages WHERE id = :id');
      $stmt->execute([
          ':id' => $id
      ]);

      return true;
   }

   public static function getLanguageById($id) {
      $db = static::getDB();
      $stmt = $db->prepare('SELECT * FROM languages WHERE id = :id');
      $stmt->execute([
          ':id' => $id
      ]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result;
   }

   public static function getLanguageByISO($iso) {
      $db = static::getDB();
      $stmt = $db->prepare('SELECT * FROM languages WHERE iso = :iso');
      $stmt->execute([
          ':iso' => $iso
      ]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result;
   }

   public static function getAllLanguages() {
      $db = static::getDB();
      $stmt = $db->prepare('SELECT * FROM languages');

      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
   }

   public static function getDefaultLanguage($router = false) {
      if($router) {
         $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
         $allLang = self::getAllLanguages();
         $langFound = false;
         foreach($allLang as $lang) {
            if($lang['iso'] === $browserLang) {
               return $lang;
            }
         }
      }

      $db = static::getDB();
      $stmt = $db->prepare('SELECT value FROM config WHERE name = "default_language_id"');

      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return self::getLanguageById($result['value']);
   }
}   