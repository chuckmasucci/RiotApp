<?php
namespace RiotApp\Models;

class SummonerSpellsModel extends RiotModel
{
    public function __construct($db, $logger)
    {
        parent::__construct();
    }

    public function getData()
    {
        $champion_data = $this->makeApiRequest(
            $base_url = "https://global.api.riotgames.com/api/lol/static-data/NA/",
            $version = "v1.2",
            $endpoint = "/champion"
        );
        $this->insertDB($table = 'champions', $columns = ['championId' => 'id', 'name' => 'name'], $champion_data->data);
    }
}
