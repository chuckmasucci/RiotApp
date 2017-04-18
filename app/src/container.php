<?php
namespace RiotApp;

use PDO;

$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer("app/templates/");

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("app/logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['Models\RiotModel'] = function ($c) {
    return new Models\RiotModel($c['db'], $c['logger']);
};

$container['Models\SummonerSpellsModel'] = function ($c) {
    return new Models\SummonerSpellsModel($c['db'], $c['logger']);
};

$container['Controllers\RiotAPIController'] = function ($c) {
    return new Controllers\RiotAPIController($c['view'], $c['router'], $c['Models\RiotModel']);
};
