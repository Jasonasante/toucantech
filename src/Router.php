<?php

namespace MVC;

class Router {
    // Array to store routes based on HTTP methods
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'OPTIONS'=>[],
    ];

    // Function to add a route to the router
    public function addRoute($method, $route, $controller, $action) {

        // store the controller and action for the specified route and method
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
        // for methods other than OPTIONS, add an OPTIONS route for CORS preflight requests
        if ($method !== 'OPTIONS') {
            $this->routes['OPTIONS'][$route] = [];
        }
    }

     // Function to dispatch a request based on method and URI
    public function dispatch($method, $uri) {

        // handle OPTIONS requests for CORS preflight
        if ($method === 'OPTIONS') {
            header('Access-Control-Allow-Origin: http://localhost:3000');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            exit();
        }

        // check if the URI is a defined route for the given method
        if (array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];
            $controller = new $controller();
            $controller->$action();
        } else {
            // If no route is found, throw an exception
            throw new \Exception("No route found for URI: $uri");
        }
    }
}

    