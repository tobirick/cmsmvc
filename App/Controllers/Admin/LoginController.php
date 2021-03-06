<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\User;
use \Core\CSRF;

class LoginController extends BaseController {
    public function index() {
        self::render('admin/login/index');
    }

    public static function login() {
        if(isset($_POST)) {
            $formErrors = User::validate($_POST['user']);
            if(!$formErrors) {
                $user = User::startLogin($_POST['user']);
                if($user) {
                    User::doLogin($user);
                    CSRF::generateToken();
                    self::redirect('/admin/dashboard');
                } else {
                    self::addFlash('error', 'Wrong password or username');
                    self::redirect('/admin/login');
                }
            } else {
                self::redirect('/admin/login');
            }
        }
    }

    public static function logout() {
        User::doLogout();
        self::redirect('/admin/dashboard');
    }
}