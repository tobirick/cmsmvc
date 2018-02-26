<?php

function checkIfNavItemIsActive($navitem) {
    return !!strpos($_SERVER['REQUEST_URI'], $navitem);
}