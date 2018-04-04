<?php

namespace App\Models;

use \Core\Model;
use PDO;
use DirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use MatthiasMullie\Minify;

class Theme extends Model {
    public static function combineCSS($themename) {
        $dir =  __DIR__  . '/../../public/' . $themename . '/css/default/';
        $minifier = new Minify\CSS();

        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            $minifier->add($dir . $fileInfo->getFilename());
        }

        $minifier->add(__DIR__  . '/../../public/' . $themename . '/css/customize.css');

        $minifiedPath = __DIR__  . '/../../public/' . $themename . '/css/main.min.css';
        $minifier->minify($minifiedPath);
    }

    public static function combineJS($themename) {
        $dir =  __DIR__  . '/../../public/' . $themename . '/js/default/';
        $minifier = new Minify\JS();

        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            $minifier->add($dir . $fileInfo->getFilename());
        }

        $minifier->add(__DIR__  . '/../../public/' . $themename . '/js/customize.js');

        $minifiedPath = __DIR__  . '/../../public/' . $themename . '/js/app.min.js';
        $minifier->minify($minifiedPath);
    }

   public static function getThemeById($id) {
      $db = static::getDB();
      $stmt = $db->prepare('SELECT * FROM themes WHERE id = :id');
      $stmt->execute([
         ':id' => $id
      ]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result) {
         $result['fixed_navigation'] = intval($result['fixed_navigation']);
         $result['to_top'] = intval($result['to_top']);
      }

      return $result;
   }

   public static function updateThemeSettings($theme, $id) {
      $db = static::getDB();
      $stmt = $db->prepare('UPDATE themes SET logo = :logo, favicon = :favicon, fixed_navigation = :fixed_navigation,
                           google_analytics = :google_analytics, to_top = :to_top, header_code = :header_code,
                           body_code = :body_code, header_layout = :header_layout, footer_layout = :footer_layout,
                           google_font = :google_font, custom_scripts = :custom_scripts, custom_styles = :custom_styles,
                           font_styles = :font_styles, default_color = :default_color, footer_bottom = :footer_bottom
                           WHERE id = :id');
      $stmt->execute([
         ':id' => $id,
         ':logo' => $theme['logo'],
         ':favicon' => $theme['favicon'],
         ':fixed_navigation' => $theme['fixed_navigation'],
         ':google_analytics' => $theme['google_analytics'],
         ':to_top' => $theme['to_top'],
         ':header_code' => $theme['header_code'],
         ':body_code' => $theme['body_code'],
         ':header_layout' => $theme['header_layout'],
         ':footer_layout' => $theme['footer_layout'],
         ':google_font' => $theme['google_font'],
         ':custom_scripts' => $theme['custom_scripts'],
         ':custom_styles' => $theme['custom_styles'],
         ':font_styles' => $theme['font_styles'],
         ':default_color' => $theme['default_color'],
         ':footer_bottom' => $theme['footer_bottom']
         ]);

      return true;
   }

    public static function addTheme($name) {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO themes (name, path) VALUES(:name, :path)');
        $stmt->execute([
            ':name' => $name,
            ':path' => 'App/Views/public/themes/' . $name
        ]);

        $lastID = $db->lastInsertId();
        return self::getThemeById($lastID);
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
        $theme = $stmt->fetch(PDO::FETCH_ASSOC);


        return $theme;
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