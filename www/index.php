<?php


error_reporting(-1);
ini_set('display_errors', '1');

function d($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

require '../vendor/autoload.php';
$config = require '../app/config/config.php';

$container = new TestWork\lib\Container($config);
$container->add('router', function() use($container) {
    return new \TestWork\lib\Router($container);
});

$container->add('db', function() use($container) {
    $dbHost = $container->getParam('db.host');
    $dbName = $container->getParam('db.name');
    $userName = $container->getParam('db.user');
    $password = $container->getParam('db.password');

    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $userName, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
});

$container->add('repository.genre', function() use($container){
    return new TestWork\repository\GenreRepository($container->get('db'));
});

$container->add('repository.video', function() use($container){
    $imagesOutputDir = __DIR__ . '/files/video';
    return new TestWork\repository\VideoRepository(
        $container->get('db'),
        $container->get('repository.genre'),
        $container->get('image_handler'),
        $imagesOutputDir
    );
});

$container->add('image_handler', function() use($container){
    return new \TestWork\lib\ImagicImageHandler();
});


$route = array_key_exists('r', $_GET) ? $_GET['r'] : $container->getParam('defaultRoute');
$router = $container->get('router');
$response = $router->runController($route);

echo $response;
