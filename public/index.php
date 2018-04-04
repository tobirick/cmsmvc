<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Credentials: true');
session_start();
require_once(__DIR__ . '/../App/init.php');
//if(isset($_SESSION['userid'])) var_dump($_SESSION['userid']);