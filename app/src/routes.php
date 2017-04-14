<?php
namespace RiotApp;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    $response = $this->view->render($response, "home.phtml");
    return $response;
});

$app->get('/api', 'Controllers\RiotAPIController:view')->setName('home');
