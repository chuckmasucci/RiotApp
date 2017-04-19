<?php
namespace RiotApp\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class HomeController
{
    private $view;
    private $models;
    private $router;

    public function __construct($view, $router, $models)
    {
        $this->view = $view;
        $this->router = $router;
        $this->models = $models;
    }

    public function view($request, $response)
    {
            // Get all matches for home page
            $matches = $this->models['matches']->getAllMatches();

            // Render to home HTML template
            return $this->view->render($response, 'home.phtml', [
                'matches' => $matches
            ]);
    }
}
