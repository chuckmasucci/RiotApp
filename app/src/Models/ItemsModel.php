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
        $item_data = $this->makeApiRequest(
            $base_url = "https://global.api.riotgames.com/api/lol/static-data/NA/",
            $version = "v1.2",
            $endpoint = "/item"
        );
        $this->insertDB($table = 'items', $columns = ['itemId' => 'id', 'name' => 'name', 'description' => 'description', 'plaintext' => 'plaintext'], $item_data->data);
    }
}
