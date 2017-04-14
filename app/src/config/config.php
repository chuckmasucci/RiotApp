<?php
$config = [
    'settings' => [
        'displayErrorDetails' => true,

        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log',
        ],
    ],
    'db' => [
        'host' => 'localhost',
        'user' => 'chuck',
        'pass' => '3Pz832',
        'dbname' => 'riot'
    ]
];
