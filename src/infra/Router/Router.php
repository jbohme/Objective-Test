<?php

namespace Infra\Router;

use App\Http\Request;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

readonly class Router
{
    /**
     * @param Container $container
     * @param array<string, array{0: string, 1: string}> $routes
     */
    public function __construct(
        private Container $container,
        private array     $routes
    ) {
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
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

        $body = json_decode((string) file_get_contents('php://input'), true) ?? [];
        $request = new Request($_GET, $body);

        $controller->$method($request);
    }
}
