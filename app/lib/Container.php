<?php

namespace TestWork\lib;


class Container
{
    private $config;

    private $services;

    public function __construct($config)
    {
        $this->config = $config;
        $this->services = [];
    }

    public function getParam($name, $default = null)
    {
        return array_key_exists($name, $this->config['params']) ? $this->config['params'][$name] : $default;
    }

    public function get($serviceName)
    {
        if (!array_key_exists($serviceName, $this->services)) {
            throw new \Exception('service not exists');
        }

        if (is_callable($this->services[$serviceName])) {
            $this->services[$serviceName] = $this->services[$serviceName]();
        }

        return $this->services[$serviceName];
    }

    public function add($name, callable $callback)
    {
        $this->services[$name] = $callback;
    }

} 