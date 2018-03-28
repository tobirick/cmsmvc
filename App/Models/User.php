<?php

namespace App\Models;

use \Core\Model;
use PDO;

class User extends Model {
    public static function validate($user) {
        $errors = [];
        // TODO: Validate email, password etc.
        if(isset($user['name']) && $user['name'] == '') {
            $errors[] = 'Name is required';
        }

        if(filter_var($user['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'invalid email';
        }

        if (strlen($user['password']) < 6) {
            $errors[] = 'Please enter at least 6 characters for the password';
        }

        return $errors;
    }

    public static function checkIfUserExists($user) {
        $db = static::getDB();
        
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([
            ':email' => $user['email']
        ]);

        $result = $stmt->fetch();

        if($result) {
            return $result;
        } else {
            return false;
        }        
    }

    public static function startRegister($user) {
        if(self::checkIfUserExists($user)) {
            // return error
            return false;
        }
        $passwordHash = password_hash($user['password'], PASSWORD_BCRYPT);
        
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO users (email, name, password_hash, created_at) VALUES(:email, :name, :password_hash, :created_at)');
        $stmt->execute([
            ':email' => $user['email'],
            ':name'=> $user['name'],
            ':password_hash'=> $passwordHash,
            ':created_at' => time()
        ]);
        return true;
    }

    public static function comparePasswords($password, $hash) {
        // compare passwords
        if(password_verify($password, $hash)) {
            return true;
        }
        return false;
    }

    public static function startLogin($userInput) {
        $user = self::checkIfUserExists($userInput);
        if($user) {
            // compare passwords
            if(self::comparePasswords($userInput['password'], $user['password_hash'])) {
                return $user;
            }
            return false;
        }
        return false;
    }

    public static function doLogin($user) {
        unset($_SESSION['userid']);
        session_regenerate_id(true);
        if(!isset($_SESSION['userid'])) {
            $_SESSION['userid'] = $user['id'];
        }
    }

    public static function doLogout() {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    public static function findById($userid) {
        $sql = 'SELECT * FROM users WHERE id = :id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userid, PDO::PARAM_INT);

        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}