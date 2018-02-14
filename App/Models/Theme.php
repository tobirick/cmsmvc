<?php

namespace App\Models;

use \Core\Model;
use PDO;
use DirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Theme extends Model {
    public static function addTheme($name) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO themes (name, path) VALUES(:name, :path)');
        $stmt->execute([
            ':name' => $name,
            ':path' => 'App/Views/public/themes/' . $name
        ]);

        return true;
    }

    public static function getAllThemeNames() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM themes');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function activateTheme($themeId) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE config SET value = :value WHERE name = :name');
        $stmt->execute([
            ':value' => $themeId,
            ':name' => 'active_theme_id'
        ]);

        return true;
    }

    public static function getActiveTheme() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM config INNER JOIN themes ON config.value = themes.id WHERE config.name = :name');
        $stmt->execute([
            ':name' => 'active_theme_id'
        ]);
        $path = $stmt->fetch(PDO::FETCH_ASSOC);


        return $path['name'];
    }

    public static function copyBaseTheme($src, $dst, $themeName = null) {
        if($themeName) self::copyBaseThemeStyles(__DIR__ . '/../../Core/basetheme_styles', __DIR__ . '/../../public/' . $themeName);
        $dir = opendir($src); 
        @mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (($file != '.') && ($file != '..')) { 
                if (is_dir($src . '/' . $file)) { 
                    self::copyBaseTheme($src . '/' . $file, $dst . '/' . $file); 
                } 
                else { 
                    copy($src . '/' . $file, $dst . '/' . $file); 
                } 
            } 
        } 
        closedir($dir);
    }

    public static function copyBaseThemeStyles($src, $dst) {
        $dir = opendir($src); 
        @mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (($file != '.') && ($file != '..')) { 
                if (is_dir($src . '/' . $file)) { 
                    self::copyBaseThemeStyles($src . '/' . $file, $dst . '/' . $file); 
                } 
                else { 
                    copy($src . '/' . $file, $dst . '/' . $file); 
                } 
            } 
        } 
        closedir($dir); 
    }

    public static function deleteTheme($dir, $themeName = null, $themeId = null) {
        if ($themeName) self::deleteThemeStyles(__DIR__ . '/../../public/' . $themeName);
        if ($themeId) self::deleteThemeFromDB($themeId);
        
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
              if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") self::deleteTheme($dir."/".$object); else unlink($dir."/".$object);
              }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public static function deleteThemeFromDB($id) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM themes WHERE id = :id');
        $stmt->execute([
            ':id' => $id
        ]);

        return true;
    }

    public static function deleteThemeStyles($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
              if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") self::deleteThemeStyles($dir."/".$object); else unlink($dir."/".$object);
              }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}