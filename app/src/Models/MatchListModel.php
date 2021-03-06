<?php
namespace RiotApp\Models;

class MatchListModel extends RiotModel
{
    protected $rows;

    public function __construct($db, $logger)
    {
        parent::__construct($db, $logger);
        $this->rows = 9;
    }

    public function getApiData()
    {
        // Clear out the database
        $this->truncate('games');

        // Query Riot API for Match List data
        $match_list_data = $this->makeApiRequest(
            $base_url = "https://na.api.riotgames.com/api/lol/NA/",
            $version = "v2.2",
            $endpoint = "/matchlist",
            $request_type = "/by-summoner/" . $this->summoner_id,
            $params = "beginIndex=0&endIndex=$this->rows"
        );

        // Insert data into `games` table
        $this->insertDB($table = 'games', $columns = ['matchId' => 'matchId', 'queue' => 'queue', 'timestamp' => 'timestamp', 'lane' => 'lane', 'role' => 'role', 'champion' => 'champion'], $match_list_data->matches);
    }


    // Get all matches - (We need to limit the query to 10 since we are using a development API key and we are limited to 10 requests per second)
    public function getAll()
    {
        $query = "SELECT * FROM games LIMIT $this->rows";
        return $this->queryDB($query);
    }
}
