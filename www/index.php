<?php

require '../vendor/autoload.php';
$config = require '../app/config/config.php';

$application = new TestWork\lib\Application($config);
$response = $application->createResponse();

echo $response;
