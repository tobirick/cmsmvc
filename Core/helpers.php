<?php

function checkIfNavItemIsActive($navitem) {
    $urlExplode = explode('/', substr($_SERVER['REQUEST_URI'], 1));
    return $navitem === $urlExplode[0];
}