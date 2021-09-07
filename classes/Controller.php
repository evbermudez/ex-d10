<?php
use Illuminate\Support;  // https://laravel.com/docs/5.8/collections - provides the collect methods & collections class
use LSS\Array2Xml;
require_once('classes/Export/Exporter.php');
require_once('classes/Player.php');

class Controller {

    public function __construct($args) {
        $this->args = $args;
    }

    public function export($type, $format) {
        $data = [];
        $exporter = new Exporter();

        if($type === 'playerstats') {
            $playersStats = new PlayerStats();

            $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
            $search = $this->args->filter(function($value, $key) use ($searchArgs) {
                return in_array($key, $searchArgs);
            })->toArray();

            $data = $playersStats->getPlayersStats($search);
        }

        if($type === 'players') {
            $players = new Player();

            $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
            $search = $this->args->filter(function($value, $key) use ($searchArgs) {
                return in_array($key, $searchArgs);
            })->toArray();

            $data = $players->getPlayers($search);
        }

        if (!$data) {
            exit("Error: No data found!");
        }

        return $exporter->format($data, $format);
    }
}