<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Media;
use \Core\CSRF;

class MediaController extends BaseController {
    public function index() {
      if(!self::checkPermission('view_media')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }
        self::render('admin/media/index');
    }

    public function store() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);

        if(!self::checkPermission('upload_media')) {         
            $data['error'] = self::getTrans('You have not the permission to do that!');
        } else {
            if($decoded['type'] === 'dir') {
                $element = Media::createFolder($decoded['folder']);
            } else if($decoded['type'] === 'file') {
                $element = [];
                foreach($decoded['files'] as $file) {
                    $uploadedFile = Media::createFile($file);
                    $element[] = $uploadedFile;
                }
            }
        }
        
        header('Content-type: application/json');
        if(isset($element) && $element) {
           $data['element'] = $element;
        } else if(!isset($data['error'])) {
           $data['error'] = self::getTrans('There was a error!');
        }
        $data['csrfToken'] = CSRF::getToken();
        
        echo json_encode($data);
    }

    public function getAllMediaElements() {
        if(!self::checkPermission('view_media')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
         }

        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        $mediaElements = Media::getAllMediaElements($decoded);

        header('Content-type: application/json');
        echo json_encode($mediaElements);
    }

    public function getAllImages() {
        if(!self::checkPermission('view_media')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
         }
         
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
        if(!self::checkPermission('edit_media')) {         
            $data['error'] = self::getTrans('You have not the permission to do that!');
        } else {
        if(isset($post['bulk'])) {
            foreach($post['elements'] as $element) {
                Media::updateMediaElementPosition($element);
            }
            $element = true;
        } else {
            $element = Media::updateMediaElement($params['params']['id'], $post['element'], $post['targetpath']);
        }
        }

        header('Content-type: application/json');
        $data['csrfToken'] = CSRF::getToken();

        if(!isset($data['error']) && !$element) {
            $data['error'] = self::getTrans('There was a error!');
        }

        echo json_encode($data);
    }

    public function destroy($params) {
        if(!self::checkPermission('delete_media')) {         
            $data['error'] = self::getTrans('You have not the permission to do that!');
        } else {
            Media::deleteMediaElement($params['params']['id']);
        }
        header('Content-type: application/json');
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }
}