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

            // We also need to update the individual match table data (single_match) for each game when we get match_list data
            if($params['req'] == 'match_list') {
                $match_list_data = $this->models[$params['req']]->getAll();
                $this->models['matches']->truncate('single_match');
                foreach ($match_list_data as $value) {
                    $this->models['matches']->getApiData($value['matchId']);
                }
            }

            return $this->view->render($response, 'api.phtml', [
                'model' => $params['req']
            ]);
        } else {
            return $this->view->render($response, 'api.phtml');
        }
    }
}
