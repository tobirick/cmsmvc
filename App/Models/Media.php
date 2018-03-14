<?php

namespace App\Models;

use \Core\Model;
use DirectoryIterator;

class Media extends Model {
    public static function getAllMediaElements() {
        $path = __DIR__ . '/../../public/content/media';
        $elements = [];

        foreach (new DirectoryIterator($path) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            $elements[] = [
                'name' => $fileInfo->getFilename(),
                'type' => $fileInfo->getType(),
                'size' => $fileInfo->getSize()
            ];
        }

        return $elements;
    }
}