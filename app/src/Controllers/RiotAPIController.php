<?php
namespace RiotApp\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class RiotAPIController
{
    private $view;
    private $model;
    private $router;

    public function __construct($view, $router, $model)
    {
        $this->view = $view;
        $this->router = $router;
        $this->model = $model;
    }

    public function view($request, $response)
    {
        return $this->view->render($response, 'home.phtml', [

        ]);
    }
}
