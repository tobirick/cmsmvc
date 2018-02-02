<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\User;
use \Core\CSRF;

class LoginController extends BaseController {
    public function index() {
        self::render('admin/login/index');
    }

    public function login() {
        CSRF::checkToken();
        if(isset($_POST)) {
            $formErrors = User::validate($_POST['user']);
            if(!$formErrors) {
                $user = User::startLogin($_POST['user']);
                if($user) {
                    User::doLogin($user);
                    self::redirect('/admin');
                } else {
                    self::render('admin/login/index', [
                       'error' => 'There was an error'
                    ]);
                }
            } else {
                self::render('admin/login/index', [
                    'formErrors' => $formErrors
                 ]);
            }
        }
    }

    public function logout() {
        User::doLogout();
        self::redirect('/admin');
    }
}