<?php
chdir(dirname(__DIR__));

require 'vendor/autoload.php';
require 'app/src/config/config.php';
session_start();

// Initiate framework
$app = new \Slim\App($config);

// Load containers
require 'app/src/container.php';

// Load routes
require 'app/src/routes.php';

$app->run();
