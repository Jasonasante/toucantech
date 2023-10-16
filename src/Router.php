<?php

namespace MVC;

class Router {
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'OPTIONS'=>[],
    ];

    public function addRoute($method, $route, $controller, $action) {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
        if ($method !== 'OPTIONS') {
            $this->routes['OPTIONS'][$route] = [];
        }
    }

    public function dispatch($method, $uri) {
        if ($method === 'OPTIONS') {
            header('Access-Control-Allow-Origin: http://localhost:3000');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            exit();
        }
        if (array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];
            $controller = new $controller();
            $controller->$action();
        } else {
            throw new \Exception("No route found for URI: $uri");
        }
    }
}

    