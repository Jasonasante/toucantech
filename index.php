<?php

// Require the autoloader to load classes automatically
require 'vendor/autoload.php';

// Get the requested URI and HTTP method
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Include the MySQL connection setup 
require 'src/Api/api.php';

// Include the configured router (returns an instance of Router)
$router = require 'src/routes.php';

// Check if $router is an instance of MVC\Router
if ($router instanceof MVC\Router) {
    // dispatch the route based on the HTTP method and URI
    $router->dispatch($method, $uri);
} else {
    // display an error message if $router is not an instance of MVC\Router
    echo "Router is not an instance of MVC\Router.";
}
