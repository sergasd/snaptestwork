<?php

namespace TestWork\lib;


class Controller
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function render($view_, $data_ = [])
    {
        $viewPath = realpath(__DIR__ . '/../views/');
        $viewFile = $viewPath . '/' . $view_ . '.php';

        if (!file_exists($viewFile)) {
            throw new \Exception('View not found');
        }

        ob_start();
        extract($data_);
        require $viewFile;
        $content = ob_get_clean();
        return $content;
    }

    public function redirect($url, $code = 302)
    {
        header("Location: $url", $code);
    }


} 