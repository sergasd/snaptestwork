<?php

namespace TestWork\lib;


use TestWork\repository\GenreRepository;
use TestWork\repository\VideoRepository;

class Application
{

    private $config;

    private $container;

    private static $_container;

    public function __construct($config)
    {
        $this->config = $config;
        $this->container = self::$_container = $this->createContainer();
    }

    private function createContainer()
    {
        $container = new Container($this->config);
        $container->add('router', function() use($container) {
            return new Router($container);
        });

        $container->add('db', function() use($container) {
            $dbHost = $container->getParam('db.host');
            $dbName = $container->getParam('db.name');
            $userName = $container->getParam('db.user');
            $password = $container->getParam('db.password');

            $pdo = new \PDO("mysql:host=$dbHost;dbname=$dbName", $userName, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        });

        $container->add('repository.genre', function() use($container){
            return new GenreRepository($container->get('db'));
        });

        $container->add('repository.video', function() use($container){
            return new VideoRepository(
                $container->get('db'),
                $container->get('repository.genre'),
                $container->get('image_handler')
            );
        });

        $container->add('image_handler', function() use($container){
            return new ImagicImageHandler();
        });

        return $container;
    }

    public function createResponse()
    {
        $route = array_key_exists('r', $_GET) ? $_GET['r'] : $this->container->getParam('defaultRoute');
        $router = $this->container->get('router');
        return $router->runController($route);
    }

    /**
     * @return Container
    */
    public static function getContainer()
    {
        return self::$_container;
    }

} 