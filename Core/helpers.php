<?php

function checkIfNavItemIsActive($navitem) {
    $pos = strpos($navitem, '/');
    if($pos) {
        $urlExplode = explode('/', substr($_SERVER['REQUEST_URI'], 1));
        return $navitem === 'admin/' . $urlExplode[1];
    } else {
        return $navitem === substr($_SERVER['REQUEST_URI'], 1);
    }
}