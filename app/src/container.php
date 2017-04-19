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

//
// Autoload Models & Controllers
//

// Root data model
$container['Models\RiotModel'] = function ($c) {
    return new Models\RiotModel($c['db'], $c['logger']);
};

// Champion model
$container['Models\ChampionsModel'] = function ($c) {
    return new Models\ChampionsModel($c['db'], $c['logger']);
};

// Match lists
$container['Models\MatchListModel'] = function ($c) {
    return new Models\MatchListModel($c['db'], $c['logger']);
};

// Individual matches
$container['Models\MatchesModel'] = function ($c) {
    return new Models\MatchesModel($c['db'], $c['logger']);
};

// Home controller
$container['Controllers\HomeController'] = function ($c) {
    return new Controllers\HomeController($c['view'], $c['router'], [
        'match_list' => $c['Models\MatchListModel'],
        'matches' => $c['Models\MatchesModel']
    ]);
};

// API controller
$container['Controllers\RiotAPIController'] = function ($c) {
    return new Controllers\RiotAPIController($c['view'], $c['router'], [
        'match_list' => $c['Models\MatchListModel'],
        'matches' => $c['Models\MatchesModel'],
        'champions' => $c['Models\ChampionsModel']
    ]);
};

// Match page
$container['Controllers\MatchController'] = function ($c) {
    return new Controllers\MatchController($c['view'], $c['router'], [
        'match_list' => $c['Models\MatchListModel'],
        'matches' => $c['Models\MatchesModel']
    ]);
};
