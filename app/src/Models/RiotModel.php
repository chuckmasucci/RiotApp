<?php

namespace RiotApp\Models;

class RiotModel
{
    protected $logger;
    protected $db;
    protected $api_key;
    protected $summoner_id;

    public function __construct($db)
    {
        // Set the class var to the db (database instance)
        $this->db = $db;

        // Riot API Key
        $this->api_key = "RGAPI-563dfbac-aa37-4bb9-a3a1-d54c8b9ea1c2";

        // Summoner (user) id
        $this->summoner_id = "35301382";
    }

    // API request helper method
    protected function makeApiRequest($base_url = NULL, $version = NULL, $endpoint = NULL, $request_type = NULL, $params = NULL)
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

    // Simple database query helper method
    protected function queryDB($query = NULL)
    {
        return $this->db->query($query)->fetchAll();
    }

    // Delete all rows from table
    protected function truncate($table) {
        return $this->db->exec("TRUNCATE TABLE $table");
    }

    // Database insert method
    protected function insertDB($table = NULL, $columns = array(), $data = NULL)
    {
        // var_dump($data);
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
        // var_dump($query);
    }
}
