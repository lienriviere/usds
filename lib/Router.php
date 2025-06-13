<?php

final class Router
{
    private $routes = [];
    public static $BASEPATH = '/';

    public function addRoute(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $path): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['path'] === $path) {
                call_user_func($route['handler']);
                return;
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function clearRoutes(): void
    {
        $this->routes = [];
    }

    public function hasRoute(string $method, string $path): bool
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['path'] === $path) {
                return true;
            }
        }
        return false;
    }

    public function getRoute(string $method, string $path): ?callable
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['path'] === $path) {
                return $route['handler'];
            }
        }
        return null;
    }
}