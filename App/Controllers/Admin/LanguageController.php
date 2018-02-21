<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \Core\CSRF;

class LanguageController extends BaseController {
    public function changeLang() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        $_SESSION['lang'] = $decoded;

        header('Content-type: application/json');
        echo json_encode($decoded);

    }
}