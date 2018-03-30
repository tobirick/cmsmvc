<?php

namespace App\Models;

use \Core\Model;
use PDO;

class UserRoles extends Model {
    public static function getAllUserRoles() {
        $sql = 'SELECT * FROM user_roles';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deletePermissionsByUserRoleID($userroleid) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM user_role_permissions WHERE user_role_id = :id');
        $stmt->execute([
            ':id' => $userroleid
        ]);
    }

    public static function createUserRole($userrolename) {
        $sql = 'INSERT INTO user_roles SET user_role_name = :user_role_name';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':user_role_name' => $userrolename
        ]);

        $lastID = $db->lastInsertId();
        return self::getUserRoleByID($lastID);
    }

    public static function deleteUserRole($userRole) {
      $db = static::getDB();
      $stmt = $db->prepare('DELETE FROM user_roles WHERE id = :id');
      $stmt->execute([
          ':id' => $userRole['id']
      ]);
    }

    public static function getUserRoleByID($id) {
        $sql = 'SELECT * FROM user_roles WHERE id = :id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateActivePermissionByUserRoleID($userroleid, $permissionid) {
        $sql = 'INSERT INTO user_role_permissions SET user_role_id = :user_role_id, permission_id = :permission_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':user_role_id' => $userroleid,
            ':permission_id' => $permissionid
        ]);
    }

    public static function getPermissions() {
        $sql = 'SELECT * FROM permissions';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPermissionsByRoleID($id) {
        $sql = 'SELECT permission_id FROM user_role_permissions WHERE user_role_id = :id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}