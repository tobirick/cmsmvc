<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\UserRoles;
use \Core\CSRF;

class UserRolesController extends BaseController {
    public function index() {
        if(!self::checkPermission('view_user_roles')) {         
            self::addFlash('error', 'You have not the permission to do that!');
            self::redirect('/admin/dashboard');
        }
        self::render('admin/user-roles/index');
    }

    public function getUserRoles() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
  
        CSRF::checkTokenAjax($decoded['csrf_token']);

        $userRoles = UserRoles::getAllUserRoles();

        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();
        $data['userRoles'] = $userRoles;
  
        echo json_encode($data);
    }

    public function updateUserRoles() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
  
        CSRF::checkTokenAjax($decoded['csrf_token']);

        foreach($decoded['userRoles'] as $userRole) {
            UserRoles::deletePermissionsByUserRoleID($userRole['id']);
            foreach($userRole['activePermissions'] as $activePermission) {
                UserRoles::updateActivePermissionByUserRoleID($userRole['id'], $activePermission);
            }
        }

        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();
  
        echo json_encode($data);
    }

    public function createUserRole() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
  
        CSRF::checkTokenAjax($decoded['csrf_token']);

        $newUserRole = UserRoles::createUserRole($decoded['userRoleName']);

        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();
        $data['userRole'] = $newUserRole;
  
        echo json_encode($data);
    }

    public function getPermissionsForRole($params) {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
  
        CSRF::checkTokenAjax($decoded['csrf_token']);

        $permissionIDs = UserRoles::getPermissionsByRoleID($params['params']['id']);

        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();
        $data['IDs'] = $permissionIDs;
  
        echo json_encode($data);
    }

    public function getPermissions() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
  
        CSRF::checkTokenAjax($decoded['csrf_token']);

        $permissions = UserRoles::getPermissions();

        header('Content-type: application/json');
        $data = [];
        $data['csrfToken'] = CSRF::getToken();
        $data['permissions'] = $permissions;
  
        echo json_encode($data);
    }
}