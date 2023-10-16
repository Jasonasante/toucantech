<?php

use MVC\Router;
use MVC\Controllers\UserController;
use MVC\Controllers\FormController;
use MVC\Controllers\ApiController;

$router = new Router();
$router->addRoute('GET','/', UserController::class, 'index');
$router->addRoute('POST','/form', FormController::class, 'processForm');
$router->addRoute('POST', '/api', ApiController::class, 'processRequest');
return $router;