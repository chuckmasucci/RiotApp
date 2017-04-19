<?php
namespace RiotApp;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//
// Site routes
//

// Home page
$app->get('/', 'Controllers\HomeController:view')->setName('home');

// Individual match page
$app->get('/match/{id}', 'Controllers\MatchController:view')->setName('match');

// API
$app->get('/api/[{req}]', 'Controllers\RiotAPIController:view')->setName('api');
