<?php

namespace RiotApp\Models;

class RiotModel
{
    private $logger;
    private $db;
    private $api_key;
    private $summoner_id;

    public function __construct($db, $logger)
    {
        $this->logger = $logger;
        $this->db = $db;

        $this->api_key = "RGAPI-563dfbac-aa37-4bb9-a3a1-d54c8b9ea1c2";
        $this->summoner_id = "35301382";

        $champion_data = $this->getChampionsAPI();

        // Get match data from Riot API
        // $match_data = $this->getMatchListAPI();

        // Update the database with the API data
        // $this->updateMatchListDB($match_data);
    }

    private function getChampionsAPI()
    {
        $base_url = "https://global.api.riotgames.com/api/lol/static-data/NA/";
        $version = "v1.2";
        $endpoint = "/champion";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $base_url . $version . $endpoint . "?api_key=" . $this->api_key
        ]);

        $resp = curl_exec($curl);
        $resp = json_decode($resp)->data;
        curl_close($curl);

        return $resp;

    }

    private function getMatchListAPI()
    {
        $base_url = "https://na.api.riotgames.com/api/lol/NA/";
        $version = "v2.2";
        $endpoint = "/matchlist";
        $request_type = "/by-summoner";
        $params = "&beginIndex=0&endIndex=25";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $base_url . $version . $endpoint . $request_type . "/" . $this->summoner_id . "?api_key=" . $this->api_key . $params
        ]);

        $resp = curl_exec($curl);
        $resp = json_decode($resp)->matches;
        curl_close($curl);

        return $resp;
    }

    private function updateMatchListDB($match_data)
    {
        $stmt = $this->db->prepare("INSERT INTO games (matchId, timestamp, lane, role, champion) VALUES (:matchId, :timestamp, :lane, :role, :champion)");
        $stmt->bindParam(':matchId', $matchId);
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->bindParam(':lane', $lane);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':champion', $champion);

        foreach ($match_data as $value) {
            $matchId = $value->matchId;
            $timestamp = date("Y-m-d H:i:s", $value->timestamp / 1000);
            $lane = $value->lane;
            $role = $value->role;
            $champion = $value->champion;
            $stmt->execute();
        }
    }
}
