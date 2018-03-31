<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\DefaultPage;
use \Core\CSRF;

class PagesController extends BaseController {
    public function index($params) {
      if(!self::checkPermission('view_page')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }
        $pageNumber = isset($_GET['p']) ? $_GET['p'] : 1;
        $numberOfPagesPerPage = 4;
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
        if(!self::checkPermission('edit_page')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }

        $id = $params['params']['id'];
        $page = DefaultPage::getPageById($id);
        if($page) {
           self::render('admin/pages/edit', [
               'page' => $page
           ]);
        } else {
           self::render('error/404');
        }
    }

    public function create() {
        if(!self::checkPermission('add_page')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        self::render('admin/pages/create');
    }

    public function store() {
        if(!self::checkPermission('add_page')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        CSRF::checkToken();
        if(isset($_POST)) {
            $page = new DefaultPage();
            $userID = self::getUser()['id'];
            $newPage = $page->addPage($_POST['page'], $userID);
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
        if(!self::checkPermission('delete_page')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        DefaultPage::deletePage($params['params']['id']);
        self::redirect('/admin/pages');
    }

    public function update($params, $post) {
        if(!self::checkPermission('edit_page')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }

        DefaultPage::updatePage($params['params']['id'], $post['page']);
        self::redirect('/admin/pages');
    }

    public function getPageByID($params) {
      $content = trim(file_get_contents("php://input"));
      $decoded = json_decode($content, true);

      CSRF::checkTokenAjax($decoded['csrf_token']);

      $page = DefaultPage::getPageById($params['params']['id']);

      header('Content-type: application/json');
      $data['page'] = $page;
      $data['csrfToken'] = CSRF::getToken();
        
      echo json_encode($data);
    }
}