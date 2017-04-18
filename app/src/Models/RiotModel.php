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
    }

    private function makeApiRequest($base_url = NULL, $version = NULL, $endpoint = NULL, $request_type = NULL, $params = NULL)
    {
        $curl = curl_init();
        $request_url = $base_url . $version . $endpoint . $request_type . "?" . $params . "&api_key=" . $this->api_key;
        
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $request_url
        ]);

        $resp = curl_exec($curl);
        $resp = json_decode($resp);
        curl_close($curl);

        return $resp;
    }

    private function insertDB($table = null, $columns = array(), $data = null)
    {
        $query = "INSERT INTO $table ";
        $query .= "(";
        foreach ($columns as $key => $value) {
            $query .= "$key, ";
        }
        $query = rtrim($query, ", ");

        $query .= ") VALUES (";
        foreach ($columns as $key => $value) {
            $query .= ":$key, ";
        }
        $query = rtrim($query, ", ");
        $query .= ")";

        $stmt = $this->db->prepare($query);

        foreach ($data as $value) {
            foreach ($columns as $db_name => $api_name) {
                if (isset($value->$api_name)) {
                    // var_dump(":" . $db_name.", ".$value->$api_name);
                    if ($db_name == "timestamp") {
                        $value->$api_name = date("Y-m-d H:i:s", $value->$api_name / 1000);
                    }
                    $stmt->bindValue(":" . $db_name, $value->$api_name);
                }
            }
            $stmt->execute();
        }
    }
}
