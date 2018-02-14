<?php

namespace App\Models;

use \Core\Model;
use PDO;
use DirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Theme extends Model {
    public static function getAllThemeNames() {
        $themePath = realpath(__DIR__ . '/../Views/public/themes');
        $directories = glob($themePath . '/*' , GLOB_ONLYDIR);
        $names = [];

        foreach($directories as $directory) {
            $names[] = substr(substr($directory, strpos($directory, '/')), 1);
        }

        return $names;
    }

    public static function activateTheme($themeName) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE config SET value = :value WHERE name = :name');
        $stmt->execute([
            ':value' => $themeName,
            ':name' => 'active_theme_name'
        ]);

        return true;
    }

    public static function getActiveTheme() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM config WHERE name = :name');
        $stmt->execute([
            ':name' => 'active_theme_name'
        ]);
        $path = $stmt->fetch(PDO::FETCH_ASSOC);

        return $path['value'];
    }

    public static function copyBaseTheme($src, $dst) {
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

    public static function deleteTheme($dir) {
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
}