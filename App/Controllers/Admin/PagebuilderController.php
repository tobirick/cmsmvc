<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Pagebuilder;
use \Core\CSRF;

class PagebuilderController extends BaseController {
    public function index() {
        //TODO: Get all pagebuilders
        self::render('admin/pagebuilder/index');
    }

    public function edit($params) {
        $id = $params['params']['id'];
        // TODO: Get pagebuilder item by id
        self::render('admin/pagebuilder/edit');
    }

    public function create() {
        self::render('admin/pagebuilder/create');
    }

    public function store() {
        CSRF::checkToken();
        if(isset($_POST)) {
            // TODO: Add new pagebuilder item
            self::redirect('/admin/pagebuilder');
        }
    }

    public function updatedestroy($params) {
        CSRF::checkToken();
        if(isset($_POST)) {
            if($_POST['_METHOD'] === 'DELETE') {
                self::delete($params);
            } else if ($_POST['_METHOD'] === 'PUT') {
                self::update($params, $_POST);
            }
        }
    }

    public function delete($params) {
        // TODO: delete pagebuilder item
        self::redirect('/admin/pagebuilder');
    }

    public function update($params, $post) {
        // TODO: Update pagebuilder item
        self::redirect('/admin/pagebuilder/' . $params['params']['id'] . '/edit' );
    }
}