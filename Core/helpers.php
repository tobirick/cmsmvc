<?php

function checkIfNavItemIsActive($navitem) {
    return !!strpos($_SERVER['REQUEST_URI'], $navitem);
}

function getURL() {
    return explode('?', $_SERVER['REQUEST_URI'])[0];
}