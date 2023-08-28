<?php

namespace TravelApp;

use FastRoute\Dispatcher;

class TravelApp {

    private $dispatcher;

    function __construct() {
        $this->setupRoutes();
    }

    /**
     * Настраивает маршруты при помощи FastRoute.
     */
    private function setupRoutes() {
        $this->dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $router) {
            $routes = require 'routes.php';

            foreach ($routes as $route) {
                $router->addRoute($route[0], $route[1], $route[2]);
            }
        } );
    }

    /**
     * Запускает обработку текущего запроса.
     */
    public function run() {
        $this->handleRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }

    /**
     * Обрабатывает запрос, анализируя HTTP метод и URI для определения вызываемого контроллера и метода.
     *
     * @param string $httpMethod HTTP метод запроса (GET, POST, PUT, DELETE и т.д.).
     * @param string $uri URI запрошенного ресурса.
     */
    private function handleRequest(string $httpMethod, string $uri) {
        
        $parsedUrl = parse_url($uri);
        $path = $parsedUrl['path'];

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $path);

        switch ($routeInfo[0]) {

            case Dispatcher::NOT_FOUND:
                    return response(404, "Метод не найден");;
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                    return response(405, "Метод не разрешён");;
                break;

            case Dispatcher::FOUND:

                // Разделяет строку "Контроллер@метод" на части.
                [$controllerClass, $method] = explode('@', $routeInfo[1]);
                $controllerClass = "TravelApp\\Controllers\\" . $controllerClass;

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();

                    // Вызывает соответствующий метод контроллера и передает параметры маршрута и POST данные (если применимо).
                    if (in_array($httpMethod, ['POST', 'PUT'])) {
                        $controller->$method($routeInfo[2], $_POST);
                    } else {
                        $controller->$method($routeInfo[2]);
                    }

                } else {
                    return response(404, "Метод не найден");
                }

                break;
        }
    }
}

?>