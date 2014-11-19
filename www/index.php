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

$application = new TestWork\lib\Application($config);
$response = $application->createResponse();

echo $response;
