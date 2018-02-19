<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\DefaultPage;
use \Core\CSRF;

class PagesController extends BaseController {
    public function index() {
        // TODO: Get all Pages from Database
        $pages = DefaultPage::getAllPages();
        self::render('admin/pages/index', [
            'pages' => $pages
        ]);
    }

    public function getAllPages() {
        $pages = DefaultPage::getAllPages();

        header('Content-type: application/json');
        echo json_encode($pages);
    }

    public function edit($params) {
        $id = $params['params']['id'];
        $page = DefaultPage::getPageById($id);
        self::render('admin/pages/edit', $page);
    }

    public function create() {
        self::render('admin/pages/create');
    }

    public function store() {
        CSRF::checkToken();
        if(isset($_POST)) {
            $page = new DefaultPage();
            $page->addPage($_POST['page']);
            self::redirect('/admin/pages');
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
        DefaultPage::deletePage($params['params']['id']);
        self::redirect('/admin/pages');
    }

    public function update($params, $post) {
        DefaultPage::updatePage($params['params']['id'], $post['page']);
        self::redirect('/admin/pages');
    }
}