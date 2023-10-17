<?php

use MVC\Router;
use MVC\Controllers\FormController;
use MVC\Controllers\ApiController;

// Create router
$router = new Router();

// Define routes for different HTTP methods and their corresponding controllers and actions
$router->addRoute('GET','/', ApiController::class, 'getAllInfo');
$router->addRoute('POST','/form', FormController::class, 'processForm');
$router->addRoute('POST', '/api', ApiController::class, 'processRequest');

// Return configured router
return $router;