<?php
namespace RiotApp\Models;

class ChampionsModel extends RiotModel
{
    public function __construct($db, $logger)
    {
        parent::__construct($db, $logger);
    }

    public function getApiData()
    {
        // Clear out the database
        $this->truncate('champions');

        // Query Riot API for Champions data
        $champion_data = $this->makeApiRequest(
            $base_url = "https://global.api.riotgames.com/api/lol/static-data/NA/",
            $version = "v1.2",
            $endpoint = "/champion",
            $request_type = NULL,
            $params = "champData=image"
        );

        // Simplify image object to just full image string
        $data = $champion_data->data;
        foreach ($data as $value) {
            $value->image = $value->image->full;
        }

        // Insert data into `champions` table
        $this->insertDB($table = 'champions', $columns = ['championId' => 'id', 'name' => 'name', 'image' => 'image'], $champion_data->data);
    }
}
