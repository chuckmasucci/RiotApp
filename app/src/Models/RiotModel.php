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

        // Summoner Spells
        $spell_data = $this->makeApiRequest(
            $base_url="https://global.api.riotgames.com/api/lol/static-data/NA/",
            $version = "v1.2",
            $endpoint = "/summoner-spell",
            $params = "&spellData=all"
        );
        $this->updateSummonerSpellDB($spell_data->data);

        // Items
        $item_data = $this->makeApiRequest(
            $base_url = "https://global.api.riotgames.com/api/lol/static-data/NA/",
            $version = "v1.2",
            $endpoint = "/item"
        );
        $this->updateItemsListDB($item_data->data);

        // Champions
        $champion_data = $this->makeApiRequest(
            $base_url = "https://global.api.riotgames.com/api/lol/static-data/NA/",
            $version = "v1.2",
            $endpoint = "/champion"
        );
        $this->updateChampionListDB($champion_data->data);

        // Champions
        $match_list_data = $this->makeApiRequest(
            $base_url = "https://na.api.riotgames.com/api/lol/NA/",
            $version = "v2.2",
            $endpoint = "/matchlist",
            $request_type = "/by-summoner/" . $this->summoner_id,
            $params = "&beginIndex=0&endIndex=25"
        );
        $this->updateMatchListDB($match_list_data->matches);


        // $match_data = $this->getMatchAPI();
    }

    private function makeApiRequest($base_url = NULL, $version = NULL, $endpoint = NULL, $request_type = NULL, $params = NULL)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $base_url . $version . $endpoint . $request_type . "?api_key=" . $this->api_key . $params
        ]);

        $resp = curl_exec($curl);
        $resp = json_decode($resp);
        curl_close($curl);

        return $resp;
    }

    private function getMatchAPI($match_id = 2473292032)
    {
        $base_url = "https://na.api.riotgames.com/api/lol/NA/";
        $version = "v2.2";
        $endpoint = "/match";
        $params = "&beginIndex=0&endIndex=25";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $base_url . $version . $endpoint . "/" . $match_id . "?api_key=" . $this->api_key . $params
        ]);

        $resp = curl_exec($curl);
        $resp = json_decode($resp);
        curl_close($curl);

        return $resp;
    }

    private function updateSummonerSpellDB($spell_data)
    {
        $stmt = $this->db->prepare("INSERT INTO summoner_spell (spellId, name, description) VALUES (:spellId, :name, :description)");
        $stmt->bindParam(':spellId', $spellId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);

        foreach ($spell_data as $value) {
            $spellId = $value->id;
            if (isset($value->name)) {
                $name = $value->name;
            }
            if (isset($value->description)) {
                $description = $value->description;
            }

            $stmt->execute();
        }
    }

    private function updateItemsListDB($item_data)
    {
        $stmt = $this->db->prepare("INSERT INTO items (itemId, name, description, plaintext) VALUES (:itemId, :name, :description, :plaintext)");
        $stmt->bindParam(':itemId', $itemId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':plaintext', $plaintext);

        foreach ($item_data as $value) {
            $itemId = $value->id;
            if (isset($value->name)) {
                $name = $value->name;
            }
            if (isset($value->description)) {
                $description = $value->description;
            }
            if (isset($value->plaintext)) {
                $plaintext = $value->plaintext;
            }

            $stmt->execute();
        }
    }

    private function updateChampionListDB($match_data)
    {
        $stmt = $this->db->prepare("INSERT INTO champions (championId, name) VALUES (:championId, :name)");
        $stmt->bindParam(':championId', $championId);
        $stmt->bindParam(':name', $name);

        foreach ($match_data as $value) {
            $championId = $value->id;
            // $key = $value->key;
            $name = $value->name;
            $stmt->execute();
        }
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
