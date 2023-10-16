<?php

require 'vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$sql = require 'src/Api/api.php';
$router = require 'src/routes.php';
if ($router instanceof MVC\Router) {
    $router->dispatch($method, $uri);
} else {
    echo "Router is not an instance of MVC\Router.";
}
