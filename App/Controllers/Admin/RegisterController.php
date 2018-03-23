<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\User;
use \Core\CSRF;

class RegisterController extends BaseController {
    public function index() {
        self::render('admin/register/index');
    }

    public function register() {
        CSRF::checkToken();
        if(isset($_POST)) {
            $formErrors = User::validate($_POST['user']);

            if(!$formErrors) {
                $user = User::startRegister($_POST['user']);
                if($user) {
                    self::redirect('/admin/dashboard');
                } else {
                    self::render('admin/register/index', [
                        'error' => 'errorororro'
                     ]);
                }
            } else {
                self::render('admin/register/index', [
                    'formErrors' => $formErrors
                 ]);
            }
        }
    }
}
