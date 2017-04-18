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
        $match_list_data = $this->makeApiRequest(
            $base_url = "https://na.api.riotgames.com/api/lol/NA/",
            $version = "v2.2",
            $endpoint = "/matchlist",
            $request_type = "/by-summoner/" . $this->summoner_id,
            $params = "beginIndex=0&endIndex=25"
        );

        $this->insertDB($table = 'games', $columns = ['matchId' => 'matchId', 'timestamp' => 'timestamp', 'lane' => 'lane', 'role' => 'role', 'champion' => 'champion'], $match_list_data->matches);
    }
}
