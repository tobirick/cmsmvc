<?php

function checkIfNavItemIsActive($navitem) {
    return $navitem === substr($_SERVER['REQUEST_URI'], 1);
}