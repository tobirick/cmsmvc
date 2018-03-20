<?php

namespace App\Models;

use \Core\Model;
use DirectoryIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Media extends Model {
    public static function getAllMediaElements($dir) {
        $json = file_get_contents(__DIR__ . '/../../public/content/media/elements.json');
        $elements = json_decode($json, true);

        if($elements) {
            foreach($elements as $index => $element) {
                if($element['path'] !== $dir) {
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

        if(!file_exists($path . $folder['name'])) {
         mkdir($path . $folder['name'], 0777, true);
        $json = file_get_contents(__DIR__ . '/../../public/content/media/elements.json');
        $elements = json_decode($json, true);
        $id = sizeof($elements) > 0 ? $elements[sizeof($elements) - 1]['id'] + 1 : 1;
        $newElement = [
            'id' => $id,
            'name' => $folder['name'],
            'type' => 'dir',
            'size' => 0,
            'path' => $folder['path'],
            'position' => 0
        ];

        $elements[] = $newElement;

        $newJson = json_encode($elements);
        file_put_contents(__DIR__ . '/../../public/content/media/elements.json', $newJson);

        return $newElement;
         } else {
            return false;
         }
    }

    public static function deleteMediaElement($id) {
        $json = file_get_contents(__DIR__ . '/../../public/content/media/elements.json');
        $elements = json_decode($json, true);

        $index = self::findIndexById($elements, $id);
        $element = $elements[$index];
        unset($elements[$index]);

        $newJson = json_encode(array_values($elements));
        file_put_contents(__DIR__ . '/../../public/content/media/elements.json', $newJson);

        $path = __DIR__ . '/../../public/content/media' . $element['path'] . $element['name'];
        self::deleteDir($path);
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
        if(!file_exists($path . $data['path'] . $data['name'])) {
         file_put_contents($path . $data['path'] . $data['name'], base64_decode($data['base']));
        $json = file_get_contents($path . 'elements.json');
        $elements = json_decode($json, true);
        $id = sizeof($elements) > 0 ? $elements[sizeof($elements) - 1]['id'] + 1 : 1;
        $newElement = [
            'id' => $id,
            'name' => $data['name'],
            'type' => 'file',
            'size' => $data['size'],
            'path' => $data['path'],
            'position' => 0
        ];

        $elements[] = $newElement;

        $newJson = json_encode($elements);
        file_put_contents($path . 'elements.json', $newJson);

        return $newElement;
      } else {
         return false;
      }
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
        $json = file_get_contents(__DIR__ . '/../../public/content/media/elements.json');
        $elements = json_decode($json, true);

        if(!file_exists(__DIR__ . '/../../public/content/media' . $targetpath . $element['name'])) {
            $index = self::findIndexById($elements, $id);
            $oldElement = $elements[$index];
            $elements[$index]['name'] = $element['name'];
            $elements[$index]['path'] = $targetpath;

            $newJson = json_encode(array_values($elements));
            file_put_contents(__DIR__ . '/../../public/content/media/elements.json', $newJson);

            $oldpath = __DIR__ . '/../../public/content/media' . $oldElement['path'] . $oldElement['name'];
            $newpath = __DIR__ . '/../../public/content/media' . $targetpath . $element['name'];
            rename($oldpath, $newpath);

            self::updateNestedMediaElements($oldElement['path'] . $oldElement['name'] . '/', $targetpath . $element['name'] . '/');
        } else {
            return false;
        }
    }

    public static function updateNestedMediaElements($path, $newpath) {
        $json = file_get_contents(__DIR__ . '/../../public/content/media/elements.json');
        $elements = json_decode($json, true);

        foreach($elements as $index => $element) {
            if($element['path'] === $path) {
                $elements[$index]['path'] = $newpath;
            }
        }

        $newJson = json_encode(array_values($elements));
        file_put_contents(__DIR__ . '/../../public/content/media/elements.json', $newJson);
    }
}