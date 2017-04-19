<?php
namespace RiotApp\Models;

class ItemsModel extends RiotModel
{
    public function __construct($db, $logger)
    {
        parent::__construct();
    }

    public function getApiData()
    {
        // Query Riot API for Items data
        $item_data = $this->makeApiRequest(
            $base_url = "https://global.api.riotgames.com/api/lol/static-data/NA/",
            $version = "v1.2",
            $endpoint = "/item"
        );

        // Insert data into `items` table
        $this->insertDB($table = 'items', $columns = ['itemId' => 'id', 'name' => 'name', 'description' => 'description', 'plaintext' => 'plaintext'], $item_data->data);
    }
}
