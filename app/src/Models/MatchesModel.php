<?php
namespace RiotApp\Models;

class MatchesModel extends RiotModel
{
    public function __construct($db, $logger)
    {
        parent::__construct($db, $logger);
    }

    public function getApiData($match_id)
    {
        // Query Riot API for Individual Match data
        $match_data = $this->makeApiRequest(
            $base_url = "https://na.api.riotgames.com/api/lol/NA/",
            $version = "v2.2",
            $endpoint = "/match",
            $request_type = "/" . $match_id
        );

        // Create parent array to conform to insert method's data requirement
        $data = array();

        // Get participant id to use as index for participants object ($match_data->participants)
        $participant_id = $this->getParticipantId($match_data->participantIdentities, $this->summoner_id);
        $participant_data = $match_data->participants[$participant_id-1];

        // Game stats
        $map_id = $match_data->mapId;
        $timestamp = $match_data->matchCreation;
        $match_duration = $match_data->matchDuration;

        // Individual stats
        $champion_id = $participant_data->championId;
        $did_win = $participant_data->stats->winner;
        $champ_level = $participant_data->stats->champLevel;
        $kills = $participant_data->stats->kills;
        $deaths = $participant_data->stats->deaths;
        $assists = $participant_data->stats->assists;
        $gold_earned = $participant_data->stats->goldEarned;
        $minions_killed = $participant_data->stats->minionsKilled;
        $spell_1_id = $participant_data->spell1Id;
        $spell_2_id = $participant_data->spell2Id;
        $item0 = $participant_data->stats->item0;
        $item1 = $participant_data->stats->item1;
        $item2 = $participant_data->stats->item2;
        $item3 = $participant_data->stats->item3;
        $item4 = $participant_data->stats->item4;
        $item5 = $participant_data->stats->item5;
        $item6 = $participant_data->stats->item6;

        // Create final data array
        $match_data_simplified = array();
        $match_data_simplified['matchId'] = $match_id;
        $match_data_simplified['mapId'] = $map_id;
        $match_data_simplified['timestamp'] = $timestamp;
        $match_data_simplified['matchDuration'] = $match_duration;

        $match_data_simplified['championId'] = $champion_id;
        $match_data_simplified['didWin'] = ($did_win) ? 1 : 0;
        $match_data_simplified['champLevel'] = $champ_level;
        $match_data_simplified['kills'] = $kills;
        $match_data_simplified['deaths'] = $deaths;
        $match_data_simplified['assists'] = $assists;
        $match_data_simplified['goldEarned'] = $gold_earned;
        $match_data_simplified['minionsKilled'] = $minions_killed;
        $match_data_simplified['spell1Id'] = $spell_1_id;
        $match_data_simplified['spell2Id'] = $spell_2_id;
        $match_data_simplified['item0'] = $item0;
        $match_data_simplified['item1'] = $item1;
        $match_data_simplified['item2'] = $item2;
        $match_data_simplified['item3'] = $item3;
        $match_data_simplified['item4'] = $item4;
        $match_data_simplified['item5'] = $item5;
        $match_data_simplified['item6'] = $item6;
        array_push($data, (object)$match_data_simplified);

        // Insert data into `single_match` table
        $this->insertDB($table = 'single_match', $columns = [
                'matchId' => 'matchId',
                'mapId' => 'mapId',
                'timestamp' => 'timestamp',
                'matchDuration' => 'matchDuration',

                'championId' => 'championId',
                'didWin' => 'didWin',
                'champLevel' => 'champLevel',
                'kills' => 'kills',
                'deaths' => 'deaths',
                'assists' => 'assists',
                'goldEarned' => 'goldEarned',
                'minionsKilled' => 'minionsKilled',
                'spell1Id' => 'spell1Id',
                'spell2Id' => 'spell2Id',
                'item0' => 'item0',
                'item1' => 'item1',
                'item2' => 'item2',
                'item3' => 'item3',
                'item4' => 'item4',
                'item5' => 'item5',
                'item6' => 'item6'],
            $data);
    }

    // Get the participant id (or index) from data
    private function getParticipantId($ids, $summonerId)
    {
        foreach ($ids as $value) {
            if ($value->player->summonerId == $summonerId) {
                return $value->participantId;
            }
        }
    }

    // Get all matches
    public function getAllMatches()
    {
        $query = "SELECT sm.id, sm.matchId, sm.mapId, sm.championId, sm.timestamp, sm.didWin, sm.champLevel, sm.kills, sm.deaths, sm.assists, c.name AS champion_name, c.image from single_match sm INNER JOIN champions c WHERE sm.championId = c.championId GROUP BY sm.id, c.name, c.image ORDER BY sm.matchId DESC";
        return $this->queryDB($query);
    }

    // Get single match by match id - we join the champions table to get the champion name and image filename
    public function getMatchById($id)
    {
        $query = "SELECT
            sm.id,
            sm.matchId,
            sm.mapId,
            sm.championId,
            sm.timestamp,
            sm.didWin,
            sm.champLevel,
            sm.goldEarned,
            sm.minionsKilled,
            sm.kills,
            sm.deaths,
            sm.assists,
            sm.matchDuration,
            sm.spell1Id,
            sm.spell2Id,
            sm.item0,
            sm.item1,
            sm.item2,
            sm.item3,
            sm.item4,
            sm.item5,
            sm.item6,
            c.name AS champion_name,
            c.image
            from single_match sm INNER JOIN champions c WHERE sm.championId = c.championId AND sm.id = $id GROUP BY sm.id, c.name, c.image ORDER BY sm.matchId DESC";

        return $this->queryDB($query);
    }
}
