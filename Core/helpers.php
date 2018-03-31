<?php

use \Core\Permission;
use \App\Models\User;


function checkIfNavItemIsActive($navitem) {
    return !!strpos($_SERVER['REQUEST_URI'], $navitem);
}

function getURL() {
    return explode('?', $_SERVER['REQUEST_URI'])[0];
}

function removeFlashSession() {
    unset($_SESSION['flash']);
}

function checkPerm($permissionname) {
   $id = Permission::getPerm($permissionname);
   $user = User::findById($_SESSION['userid']);
   if(array_search($id, $user['permissions']) !== false) {
       return true;
   }

   return false;
}