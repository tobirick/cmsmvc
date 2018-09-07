<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\DefaultPage;
use \App\Models\Language;
use \Core\CSRF;

class PagesController extends BaseController {
    public function index($params) {
      if(!self::checkPermission('view_page')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }
        $pageNumber = isset($_GET['p']) ? $_GET['p'] : 1;
        $numberOfPagesPerPage = 15;
        $numberOfPages = ceil(DefaultPage::countPages() / $numberOfPagesPerPage);

        if($numberOfPages <= 0 || $numberOfPages == 1) {
            $numberOfPages = 1;
        }

        $lang = \App\Models\Language::getDefaultLanguage(true);
        $pagesadmin = DefaultPage::getAllPages($pageNumber, $numberOfPagesPerPage, $lang['id']);
        self::render('admin/pages/index', [
            'pagesadmin' => $pagesadmin,
            'currentpage' => $pageNumber,
            'numberofpages' => $numberOfPages,
            'numberofpagesperpage' => $numberOfPagesPerPage
        ]);
    }

    public function getAllPages() {
        $lang = \App\Models\Language::getDefaultLanguage(true);
        $pages = DefaultPage::getAllPages(1, 99999999, $lang['id']);

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
            $page = new DefaultPage($_POST['page']);
            $userID = self::getUser()['id'];
            $errors = $page->validate();
            if(!$errors) {
                $newPage = $page->savePage($userID);
                $languages = Language::getAllLanguages();
                foreach($languages as $language) {
                   DefaultPage::addPageContents($newPage['id'], $language['id'], $_POST['page']['slug']);
                }
                self::redirect('/admin/pages/' . $newPage['id'] . '/edit');
            } else {
                self::redirect('/admin/pages/create');
            }
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

      $defaultPage = DefaultPage::getPageById($params['params']['id']);

        $data['langs'] = [];

        $languages = Language::getAllLanguages();

        foreach($languages as $language) {
            $page = DefaultPage::getPageContentsByID($params['params']['id'], $language['id']);
            $data['langs'][] = $page;
        }

      header('Content-type: application/json');
      $data['csrfToken'] = CSRF::getToken();
      $data['defaultPage'] = $defaultPage;
        
      echo json_encode($data);
    }

    public function setInEditInActive() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);

        DefaultPage::setEditStatus($decoded['pageID'], 0);

        header('Content-type: application/json');
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }
}