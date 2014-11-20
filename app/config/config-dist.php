<?php

return [
    'params' => [
        'db.host' => 'localhost',
        'db.name' => 'testwork',
        'db.user' => 'root',
        'db.password' => '',
        'db.charset' => 'utf8',

        'defaultRoute' => 'video/index',
        'basePath' => dirname(__DIR__), // базовый путь
        'webPath' => dirname(dirname(__DIR__)) . '/www', // путь к public части приложения
        'baseUrl' => '', // если приложение в подпапке, то тут имя папки, если нет - то оставить пустым
    ],
];