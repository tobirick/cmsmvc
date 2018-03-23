<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Media;
use \Core\CSRF;

class MediaController extends BaseController {
    public function index() {
        self::render('admin/media/index');
    }

    public function store() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);

        if($decoded['type'] === 'dir') {
            $element = Media::createFolder($decoded['folder']);
        } else if($decoded['type'] === 'file') {
            $element = Media::createFile($decoded['file']);            
        }
        
        header('Content-type: application/json');
        $data = [];
        if($element) {
           $data['element'] = $element;
        } else {
           $data['error'] = 'There was a error!';
        }
        $data['csrfToken'] = CSRF::getToken();
        
        echo json_encode($data);
    }

    public function getAllMediaElements() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        $mediaElements = Media::getAllMediaElements($decoded);

        header('Content-type: application/json');
        echo json_encode($mediaElements);
    }

    public function getAllImages() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        $elements = Media::getImages();

        $data = [];
        $data['elements'] = $elements;

        echo json_encode($data);
    }

    public function updatedestroy($params) {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);
        if($decoded['_METHOD'] === 'DELETE') {
            self::destroy($params);
        } else if ($decoded['_METHOD'] === 'PUT') {
            self::update($params, $decoded);
        }
    }

    public function update($params, $post) {
       if(isset($post['bulk'])) {
          foreach($post['elements'] as $element) {
            Media::updateMediaElementPosition($element);
          }
          $element = true;
      } else {
         $element = Media::updateMediaElement($params['params']['id'], $post['element'], $post['targetpath']);
      }

        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();

        if(!$element) {
            $data['error'] = 'There was a error!';
        }

        echo json_encode($data);
    }

    public function destroy($params) {
        Media::deleteMediaElement($params['params']['id']);
        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }
}