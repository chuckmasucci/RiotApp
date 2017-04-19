<?php
namespace RiotApp\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class MatchController
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

    public function view($request, $response, $params)
    {
        // Check URL query string parameter for an id
        if(isset($params['id'])) {
            
            // Get an individual match by id
            $match = $this->models['matches']->getMatchById($params['id'])[0];

            // Render to match HTML template
            return $this->view->render($response, 'match.phtml', [
                'match' => $match
            ]);
        }
    }
}
