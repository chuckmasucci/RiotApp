<?php
namespace RiotApp\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class RiotAPIController
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
        if(isset($params['req'])) {
            $this->models[$params['req']]->getApiData();
            return $this->view->render($response, 'api.phtml', [
                'model' => $params['req']
            ]);
        } else {
            return $this->view->render($response, 'api.phtml');
        }


    }
}
