<?php 

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\User;
use \App\Models\UserRoles;
use \Core\CSRF;

class UsersController extends BaseController {
    public function index($params) {
        if(!self::checkPermission('view_users')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        $users = User::getAllUsers();
        self::render('admin/users/index', [
          'users' => $users
        ]);
    }

    public function edit($params) {
        if(!self::checkPermission('edit_user')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        $id = $params['params']['id'];
        $user = User::findById($id);
        $userroles = UserRoles::getAllUserRoles();
        if($user) {
           self::render('admin/users/edit', [
               'user' => $user,
               'userroles' => $userroles
           ]);
        } else {
           self::render('error/404');
        }
    }

    public function create() {
        if(!self::checkPermission('add_user')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        self::render('admin/users/create');
    }

    public function store() {
        if(!self::checkPermission('add_user')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        CSRF::checkToken();
        if(isset($_POST)) {
            $formErrors = User::validate($_POST['user']);
            if(!$formErrors) {
                $user = User::startRegister($_POST['user']);
                if($user) {
                    self::redirect('/admin/users/' . $user['id'] . '/edit');
                } else {
                    self::redirect('/admin/users/create');
                }
            } else {
                self::redirect('/admin/users/create');
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
        if(!self::checkPermission('delete_user')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        User::deleteUser($params['params']['id']);
        self::redirect('/admin/users');
    }

    public function update($params, $post) {
        if(!self::checkPermission('edit_user')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        User::updateUser($params['params']['id'], $post['user']);
        self::redirect('/admin/users');
    }
}