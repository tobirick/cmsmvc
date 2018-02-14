<?php

function checkIfNavItemIsActive($navitem) {
    if(strpos($navitem, '\/')) {
        $urlExplode = explode('/', substr($_SERVER['REQUEST_URI'], 1));
        return $navitem === 'admin/' . $urlExplode[1];
    } else {
        return $navitem === substr($_SERVER['REQUEST_URI'], 1);
    }
}