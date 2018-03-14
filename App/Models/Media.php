<?php

namespace App\Models;

use \Core\Model;
use DirectoryIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Media extends Model {
    public static function getAllMediaElements($foldername = '') {
        $json = file_get_contents(__DIR__ . '/../../public/content/media/elements.json');
        $elements = json_decode($json, true);
        
        return $elements;
    }

    public static function createFolder($folder) {
        $path = __DIR__ . '/../../public/content/media' . $folder['path'];

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
    }

    public static function deleteMediaElement($folderid) {
        $json = file_get_contents(__DIR__ . '/../../public/content/media/elements.json');
        $elements = json_decode($json, true);

        $index = self::findIndexById($elements, $folderid);
        $folder = $elements[$index];
        unset($elements[$index]);

        $newJson = json_encode(array_values($elements));
        file_put_contents(__DIR__ . '/../../public/content/media/elements.json', $newJson);

        $path = __DIR__ . '/../../public/content/media' . $folder['path'] . $folder['name'];
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

    public static function createFile() {
        // Create file
        // add to .json file
    }

    public static function deleteDir($dirPath) {
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
}