<?php
namespace RiotApp\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// use \RiotApp\Models\RiotModel;

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
        // $this->model->getMatchList();
        return $this->view->render($response, 'home.phtml', [

        ]);
    }
}
