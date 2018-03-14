<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Media;

class MediaController extends BaseController {
    public function index() {
        self::render('admin/media/index');
    }

    public function getAllMediaElements() {
        $mediaElements = Media::getAllMediaElements();

        header('Content-type: application/json');
        echo json_encode($mediaElements);
    }
}