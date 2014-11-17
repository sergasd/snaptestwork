<?php


namespace TestWork\lib;


class Router
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function runController($route)
    {
        $route = explode('/', (string) $route);

        if (count($route) !== 2) {
            throw new \Exception('Wrong route');
        }

        $controllerClassName = 'TestWork\\controllers\\' . ucfirst($route[0]) . 'Controller';

        if (!class_exists($controllerClassName)) {
            throw new \Exception('Controller not found');
        }

        $controller = new $controllerClassName($this->container);

        $action = ucfirst($route[1]) . 'Action';
        if (method_exists($controller, $action)) {
            return call_user_func([$controller, $action]);
        } else {
            throw new \Exception('Action not found');
        }
    }

} 