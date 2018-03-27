<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\DefaultPage;
use \Core\CSRF;

class PagesController extends BaseController {
    public function index($params) {
        $pageNumber = isset($_GET['p']) ? $_GET['p'] : 1;
        $numberOfPagesPerPage = 12;
        $numberOfPages = ceil(DefaultPage::countPages() / $numberOfPagesPerPage);

        if($numberOfPages <= 0 || $numberOfPages == 1) {
            $numberOfPages = 1;
        }

        $pagesadmin = DefaultPage::getAllPages($pageNumber, $numberOfPagesPerPage);
        self::render('admin/pages/index', [
            'pagesadmin' => $pagesadmin,
            'currentpage' => $pageNumber,
            'numberofpages' => $numberOfPages,
            'numberofpagesperpage' => $numberOfPagesPerPage
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
        self::render('admin/pages/edit', [
            'page' => $page
        ]);
    }

    public function create() {
        self::render('admin/pages/create');
    }

    public function store() {
        CSRF::checkToken();
        if(isset($_POST)) {
            $page = new DefaultPage();
            $newPage = $page->addPage($_POST['page']);
            self::redirect('/admin/pages/' . $newPage['id'] . '/edit');
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