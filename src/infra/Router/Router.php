<?php

namespace Infra\Router;

use App\Http\Request;
use DI\Container;

class Router
{
    public function __construct(
        private Container $container,
        private array $routes
    )
    {
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $routeKey = "$method $uri";

        if (!isset($this->routes[$routeKey])) {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found.']);
            return;
        }

        [$controllerClass, $method] = $this->routes[$routeKey];
        $controller = $this->container->get($controllerClass);

        $body = json_decode(file_get_contents('php://input'), true) ?? [];
        $request = new Request($_GET, $body);

        $controller->$method($request);
    }
}
