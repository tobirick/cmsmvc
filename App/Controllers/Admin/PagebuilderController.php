<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Pagebuilder;
use \Core\CSRF;

class PagebuilderController extends BaseController {
    public function index() {
        $pagebuilderitems = Pagebuilder::getAllItems();
        self::render('admin/pagebuilder/index', [
            'pagebuilderitems' => $pagebuilderitems
        ]);
    }

    public function edit($params) {
        $id = $params['params']['id'];
        $item = Pagebuilder::getItemById($id);
        self::render('admin/pagebuilder/edit', $item);
    }

    public function create() {
        self::render('admin/pagebuilder/create');
    }

    public function store() {
        CSRF::checkToken();
        if(isset($_POST)) {
            // TODO: Add new pagebuilder item
            Pagebuilder::createItem($_POST['item']);
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
        Pagebuilder::deleteItem($params['params']['id']);
        self::redirect('/admin/pagebuilder');
    }

    public function update($params, $post) {
        Pagebuilder::updateItem($params['params']['id'], $post['item']);
        self::redirect('/admin/pagebuilder');
    }

    public function getAllPagebuilderItems() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);

        $pagebuilderItems = Pagebuilder::getAllItems();

        header('Content-type: application/json');
        $data = [];
        $data['pagebuilderItems'] = $pagebuilderItems;
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }

    public function getPagebuilderItemByID($params) {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);

        $pagebuilderItemID = $params['params']['id'];

        $pagebuilderItem = Pagebuilder::getItemById($pagebuilderItemID);

        header('Content-type: application/json');
        $data = [];
        $data['pagebuilderitem'] = $pagebuilderItem;
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }

    public function updatePagebuilderItem($params) {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);

        $pagebuilderItemID = $params['params']['id'];

        Pagebuilder::updateItem($pagebuilderItemID, $decoded['pagebuilderitem']);

        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }

    public function addPagebuilderItem() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);


        $pagebuilderitem = Pagebuilder::createItem($decoded['pagebuilderitem']);

        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();
        $data['pagebuilderID'] = $pagebuilderitem['id'];

        echo json_encode($data);
    }

    public function savePagebuilder() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);
        $sections = $decoded['sections'];

        // Delete all sections
        Pagebuilder::deleteSectionsByPageID($decoded['page_id']);
        Pagebuilder::saveHTMLToPage($decoded['page_id'], $decoded['html']);

        // Insert updated sections, rows, columnsrows and rows
        foreach($sections as $key => $section) {
            $sectionID = Pagebuilder::saveSection($decoded['page_id'], $section);

            foreach($section['rows'] as $key2 => $row) {
                $rowID = Pagebuilder::saveRow($sectionID, $row);

                foreach($row['columnrows'] as $key3 => $columnrow) {
                    $columndRowID = Pagebuilder::saveColumnRow($rowID, $columnrow);

                    foreach($columnrow['columns'] as $key4 => $column) {
                        $columnID = Pagebuilder::saveColumn($columndRowID, $column);
                        if($column['element']) {
                           Pagebuilder::saveElement($columnID, $column['element']);
                        }
                    }
                }
            }
        }

        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();

        echo json_encode($data);
    }

    public function getSectionsByPageID($params) {
        $pageID = $params['params']['pageid'];
        $sections = Pagebuilder::getSectionsByPageID($pageID);
        
        header('Content-type: application/json');
        echo json_encode($sections);
    }

    public function getRowsBySectionID($params) {
        $sectionID = $params['params']['sectionid'];
        $rows = Pagebuilder::getRowsBySectionID($sectionID);
        
        header('Content-type: application/json');
        echo json_encode($rows);
    }

    public function getColumnRowsByRowID($params) {
        $rowID = $params['params']['rowid'];
        $columnrows = Pagebuilder::getColumnRowsByRowID($rowID);
        
        header('Content-type: application/json');
        echo json_encode($columnrows);
    }

    public function getColumnsByColumnRowID($params) {
        $columnRowID = $params['params']['columnrowid'];
        $columns = Pagebuilder::getColumnsByColumnRowID($columnRowID);
        
        header('Content-type: application/json');
        echo json_encode($columns);
    }

    public function getElementByColumnID($params) {
      $columnID = $params['params']['columnid'];
      $element = Pagebuilder::getElementByColumnID($columnID);
      
      header('Content-type: application/json');
      echo json_encode($element);
    }
}