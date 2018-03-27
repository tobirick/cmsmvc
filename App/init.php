<?php
// ENV
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

// Errors
if(filter_var(getenv('SHOW_ERROR'), FILTER_VALIDATE_BOOLEAN)) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

$db = \Core\Model::getDB();

if(!$db) {
    require_once(__DIR__ . '/../public/install.php');
    exit;
}

// Redirects
$requestURL = $_SERVER['REQUEST_URI'];
if($requestURL === '/admin/' || $requestURL === '/admin') {
    header('Location: /admin/dashboard');
}

// Routes
require_once(__DIR__ . '/Routes/index.php');
use \Core\Router;
$routeDispatcher = new Router($router);
