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
        $spell_data = $this->makeApiRequest(
            $base_url="https://global.api.riotgames.com/api/lol/static-data/NA/",
            $version = "v1.2",
            $endpoint = "/summoner-spell",
            $request_type = NULL,
            $params = "spellData=all"
        );
        $this->insertDB($table = 'summoner_spell', $columns = ['spellId' => 'id', 'name' => 'name', 'description' => 'description'], $spell_data->data);
    }
}
