<?php
// Errors
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// ENV
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

// Redirects
$requestURL = $_SERVER['REQUEST_URI'];
if($requestURL === '/admin/' || $requestURL === '/admin') {
    header('Location: /admin/dashboard');
}

// Routes
require_once(__DIR__ . '/Routes/index.php');
use \Core\Router;
$language = new \Core\Language();
$routeDispatcher = new Router($router, $language);