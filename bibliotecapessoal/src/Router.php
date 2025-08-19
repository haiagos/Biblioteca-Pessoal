<?php

class Router {
    private $routes = [];

    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function resolve($requestMethod, $requestPath) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestPath) {
                $controller = new $route['controller']();
                return call_user_func([$controller, $route['action']]);
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}