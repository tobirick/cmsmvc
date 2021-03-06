<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Pagebuilder;
use \App\Models\DefaultPage;
use \Core\CSRF;

class PagebuilderController extends BaseController {
    public function index() {
      if(!self::checkPermission('view_pagebuilder_item')) {         
         self::addFlash('error', self::getTrans('You have not the permission to do that!'));
         self::redirect('/admin/dashboard');
      }
        $pagebuilderitems = Pagebuilder::getAllItems();
        self::render('admin/pagebuilder/index', [
            'pagebuilderitems' => $pagebuilderitems
        ]);
    }

    public function edit($params) {
        if(!self::checkPermission('edit_pagebuilder_item')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        $id = $params['params']['id'];
        $item = Pagebuilder::getItemById($id);
        if($item) {
           self::render('admin/pagebuilder/edit', $item);
        } else {
           self::render('error/404');
        }
    }

    public function create() {
        if(!self::checkPermission('add_pagebuilder_item')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        self::render('admin/pagebuilder/create');
    }

    public function store() {
        if(!self::checkPermission('add_pagebuilder_item')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
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
        if(!self::checkPermission('delete_pagebuilder_item')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        Pagebuilder::deleteItem($params['params']['id']);
        self::redirect('/admin/pagebuilder');
    }

    public function update($params, $post) {
        if(!self::checkPermission('edit_pagebuilder_item')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
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

    /*
    public function savePagebuilder() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        CSRF::checkTokenAjax($decoded['csrf_token']);
        $sections = $decoded['sections'];

        foreach($decoded['languages'] as $language) {
            Pagebuilder::updatePageContent($decoded['page_id'], $language['language_id'], $language['html'], $language['page']);
        }

        // Delete Sections
        foreach($decoded['deletedSections'] as $section) {
            Pagebuilder::deleteSectionByID($section);
        }

        DefaultPage::updatePage($decoded['page_id'], $decoded['defaultPage']);

        // Insert updated sections, rows, columnsrows and rows
        foreach($sections as $key => $section) {
            // Check if Section exists
            if(Pagebuilder::checkIfSectionExists($section['id'])) {
                Pagebuilder::updateSection($section, $key);
                $sectionID = $section['id'];
            } else {
                $sectionID = Pagebuilder::saveSection($decoded['page_id'], $section, $key);
            }

            // Delete all deleted rows in section
            foreach($section['deletedRows'] as $row) {
                Pagebuilder::deleteRowByID($row);
            }

            foreach($section['rows'] as $key2 => $row) {
                // Check if Row exists
                if(Pagebuilder::checkIfRowExists($row['id'])) {
                    Pagebuilder::updateRow($sectionID, $row, $key2);
                    $rowID = $row['id'];
                } else {
                    $rowID = Pagebuilder::saveRow($sectionID, $row, $key2);
                }

                    foreach($row['columnrows'] as $key3 => $columnrow) {

                        // Delete columns in column row
                        foreach($columnrow['deletedColumns'] as $column) {
                            Pagebuilder::deleteColumnByID($column);
                        }              

                        // Check if column row exists
                        if(sizeof($columnrow['columns']) !== 0) {
                            if(Pagebuilder::checkIfColumnRowExists($columnrow['id'])) {
                                Pagebuilder::updateColumnRow($rowID, $columnrow, $key3);
                                $columnRowID = $columnrow['id'];
                            } else {
                                $columnRowID = Pagebuilder::saveColumnRow($rowID, $columnrow, $key3);
                            }
        
                            foreach($columnrow['columns'] as $key4 => $column) {
                                // Check if Column exists
                                if(Pagebuilder::checkIfColumnExists($column['id'])) {
                                    Pagebuilder::updateColumn($columnRowID, $column, $key4);
                                    $columnID = $column['id'];
                                } else {
                                    $columnID = Pagebuilder::saveColumn($columnRowID, $column, $key4);
                                }

                                // Delete elements in columns
                                foreach($column['deletedElements'] as $element) {
                                    Pagebuilder::deleteElementByID($element);
                                } 

                                // Check if Element exists
                                if($column['element']) {
                                    if(Pagebuilder::checkIfElementExists($column['element']['id'])) {
                                        Pagebuilder::updateElement($columnID, $column['element']);
                                    } else {
                                        Pagebuilder::saveElement($columnID, $column['element']);
                                    }
                                }
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
    */

    public function savePagebuilder() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        CSRF::checkTokenAjax($decoded['csrf_token']);
        $sections = $decoded['sections'];
        // Delete all sections
        Pagebuilder::deleteSectionsByPageID($decoded['page_id']);
        foreach($decoded['languages'] as $language) {
            Pagebuilder::updatePageContent($decoded['page_id'], $language['language_id'], $language['html'], $language['page']);
        }
        DefaultPage::updatePage($decoded['page_id'], $decoded['defaultPage']);
        // Insert updated sections, rows, columnsrows and rows
        foreach($sections as $key => $section) {
            $sectionID = Pagebuilder::saveSection($decoded['page_id'], $section, 0);
            foreach($section['rows'] as $key2 => $row) {
                $rowID = Pagebuilder::saveRow($sectionID, $row, 0);
                    foreach($row['columnrows'] as $key3 => $columnrow) {
                        if(sizeof($columnrow['columns']) !== 0) {
                            $columndRowID = Pagebuilder::saveColumnRow($rowID, $columnrow, 0);
        
                            foreach($columnrow['columns'] as $key4 => $column) {
                                $columnID = Pagebuilder::saveColumn($columndRowID, $column, 0);
                                if($column['element']) {
                                   Pagebuilder::saveElement($columnID, $column['element']);
                                }
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
      $content = trim(file_get_contents("php://input"));
      $decoded = json_decode($content, true);

      CSRF::checkTokenAjax($decoded['csrf_token']);

        $pageID = $params['params']['pageid'];
        $sections = Pagebuilder::getSectionsByPageID($pageID);

        foreach($sections as $index => $section) {
            $rows = Pagebuilder::getRowsBySectionID($section['id']);
            $section['rows'] = $rows;
            $sections[$index]['rows'] = $rows;

            foreach($section['rows'] as $index2 => $row) {
                $columnrows = Pagebuilder::getColumnRowsByRowID($row['id']);
                $row['columnrows'] = $columnrows;
                $sections[$index]['rows'][$index2]['columnrows'] = $columnrows;

                foreach($row['columnrows'] as $index3 => $columnrow) {
                    $columns = Pagebuilder::getColumnsByColumnRowID($columnrow['id']);
                    $columnrow['columns'] = $columns;
                    $sections[$index]['rows'][$index2]['columnrows'][$index3]['columns'] = $columns;

                    foreach($columnrow['columns'] as $index4 => $column) {
                        $element = Pagebuilder::getElementByColumnID($column['id']);
                        $column['element'] = $element;
                        $sections[$index]['rows'][$index2]['columnrows'][$index3]['columns'][$index4]['element'] = $element;
                    }
                }
            }
        }
        
        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();
        $data['sections'] = $sections;

        echo json_encode($data);
    }
}