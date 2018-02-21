<?php

namespace Core;

class CSRF {  
    public function getToken() {
        $token = new Token();
        $value = $token->getValue();
        $_SESSION["csrf_token"] = $value;
 
        return $value;
    }

    public static function checkToken() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['csrf_token'])) {
                header('HTTP/1.0 403 Forbidden');
                exit('Missing CSRF token');
            }
 
            // Get the token from the session and remove it
            $token = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';

            unset($_SESSION['csrf_token']);
            if ($_POST['csrf_token'] != $token) {
                header('HTTP/1.0 403 Forbidden');
                exit('Invalid CSRF token');
            }  
        }   
    }

    public static function checkTokenAjax($formtoken) {
            if (!isset($formtoken)) {
                header('HTTP/1.0 403 Forbidden');
                exit('Missing CSRF token');
            }
 
            // Get the token from the session and remove it
            $token = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';

            unset($_SESSION['csrf_token']);
            if ($formtoken != $token) {
                header('HTTP/1.0 403 Forbidden');
                exit('Invalid CSRF token');
            }    
    }
}