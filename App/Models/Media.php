<?php

namespace App\Models;

use \Core\Model;
use DirectoryIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;

class Media extends Model {
    public static $mediajsonpath = __DIR__ . '/../../Core/mediaelements.json';

    public static function sonderzeichen($string) {
        $search = array("Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "´");
        $replace = array("Ae", "Oe", "Ue", "ae", "oe", "ue", "ss", "");
        return str_replace($search, $replace, $string);
    }

    public static function getAllMediaElements($dir) {
        $json = file_get_contents(self::$mediajsonpath);
        $elements = json_decode($json, true);

        if($elements) {
            foreach($elements as $index => $element) {
                if($element['path'] !== $dir) {
                    unset($elements[$index]);
                }
            }
            usort($elements, function($a, $b) {
               return $a['position'] - $b['position'];
            });
            return array_values($elements);
        } else {
            return [];
        }
    }

    public static function getImages() {
        $json = file_get_contents(self::$mediajsonpath);
        $elements = json_decode($json, true);

        if($elements) {
            foreach($elements as $index => $element) {
                if($element['type'] !== 'file') {
                    unset($elements[$index]);
                }
            }
            return array_values($elements);
        } else {
            return [];
        }
    }

    public static function createFolder($folder) {
        $path = __DIR__ . '/../../public/content/media' . $folder['path'];
        $foldername = self::sonderzeichen($folder['name']);

        if(!file_exists($path . $foldername)) {
         mkdir($path . $foldername, 0777, true);
        $json = file_get_contents(self::$mediajsonpath);
        $elements = json_decode($json, true);
        $id = sizeof($elements) > 0 ? $elements[sizeof($elements) - 1]['id'] + 1 : 1;
        $newElement = [
            'id' => $id,
            'name' => $foldername,
            'type' => 'dir',
            'size' => '0 KB / 0 Files',
            'path' => $folder['path'],
            'position' => 0
        ];

        $elements[] = $newElement;

        $newJson = json_encode($elements);
        file_put_contents(self::$mediajsonpath, $newJson);

        return $newElement;
         } else {
            return false;
         }
    }

    public static function deleteMediaElement($id) {
        $json = file_get_contents(self::$mediajsonpath);
        $elements = json_decode($json, true);

        $index = self::findIndexById($elements, $id);
        $element = $elements[$index];
        unset($elements[$index]);

        $newJson = json_encode(array_values($elements));
        file_put_contents(self::$mediajsonpath, $newJson);

        $path = __DIR__ . '/../../public/content/media' . $element['path'] . $element['name'];
        self::deleteDir($path);
        self::updateFileSize();
    }

    public static function findIndexById($array, $id) {
        foreach($array as $index => $arrayelement) {
            if($arrayelement['id'] == $id) {
                return $index;
            }
        }

        return false;
    }

    public static function createFile($data) {
        // Create file
        $path = __DIR__ . '/../../public/content/media/';
        $filename = self::sonderzeichen($data['name']);

        if(!file_exists($path . $data['path'] . $filename)) {
         file_put_contents($path . $data['path'] . $filename, base64_decode($data['base']));
        $json = file_get_contents(self::$mediajsonpath);
        $elements = json_decode($json, true);
        $id = sizeof($elements) > 0 ? $elements[sizeof($elements) - 1]['id'] + 1 : 1;
        $newElement = [
            'id' => $id,
            'name' => $filename,
            'type' => 'file',
            'size' => $data['size'] . ' KB',
            'path' => $data['path'],
            'position' => 0
        ];

        $elements[] = $newElement;

        
        $newJson = json_encode($elements);
        file_put_contents(self::$mediajsonpath, $newJson);

        self::updateFileSize();

        return $newElement;
      } else {
         return false;
      }
    }

    public static function updateFileSize() {
        $path = __DIR__ . '/../../public/content/media/';

        $json = file_get_contents(self::$mediajsonpath);
        $elements = json_decode($json, true);

        foreach($elements as $index => $element) {
            $elements[$index]['size'] = self::getFileInfos(__DIR__ . '/../../public/content/media' . $element['path'] . $element['name']);
        }

        $newJson = json_encode(array_values($elements));

        file_put_contents(self::$mediajsonpath, $newJson);
    }
    
    public static function getFileInfos($path) {
        $bytestotal = 0;
        $count = 0;
        $path = realpath($path);
        if($path!==false && $path!='' && file_exists($path)){
           if(is_dir($path)) {
               foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                  $bytestotal += $object->getSize();
                  if($object->isDir()) continue;
                  $count++;
               }
            } else {
               return number_format(filesize($path)) . ' KB';
            }
        }
        return number_format($bytestotal) . ' KB / ' . $count . ' Files';
    }

    public static function deleteDir($dirPath) {
        if(is_file($dirPath)) {
            unlink($dirPath);
            return;
        }
        $it = new RecursiveDirectoryIterator($dirPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
                     RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dirPath);
    }

    public static function updateMediaElement($id, $element, $targetpath) {
        $json = file_get_contents(self::$mediajsonpath);
        $elements = json_decode($json, true);

        if(!file_exists(__DIR__ . '/../../public/content/media' . $targetpath . $element['name'])) {
            $index = self::findIndexById($elements, $id);
            $oldElement = $elements[$index];
            $elements[$index]['path'] = $targetpath;

            $newJson = json_encode(array_values($elements));
            file_put_contents(self::$mediajsonpath, $newJson);

            $oldpath = __DIR__ . '/../../public/content/media' . $oldElement['path'] . $oldElement['name'];
            $newpath = __DIR__ . '/../../public/content/media' . $targetpath . $element['name'];
            rename($oldpath, $newpath);

            self::updateNestedMediaElements($oldElement['path'] . $oldElement['name'] . '/', $targetpath . $element['name'] . '/');

            self::updateFileSize();
            return true;
        } else {
            return false;
        }
    }

    public static function updateMediaElementPosition($element) {
      $json = file_get_contents(self::$mediajsonpath);
      $elements = json_decode($json, true);

      foreach($elements as $index => $elementjson) {
         if($elementjson['id'] === $element['id']) {
             $elements[$index]['position'] = $element['position'];
         }
      }

      $newJson = json_encode(array_values($elements));
      file_put_contents(self::$mediajsonpath, $newJson);
    }

    public static function updateNestedMediaElements($path, $newpath) {
        $json = file_get_contents(self::$mediajsonpath);
        $elements = json_decode($json, true);

        foreach($elements as $index => $element) {
            if($element['path'] === $path) {
                $elements[$index]['path'] = $newpath;
            }
        }

        $newJson = json_encode(array_values($elements));
        file_put_contents(self::$mediajsonpath, $newJson);
    }
}