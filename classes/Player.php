<?php
include('classes/Model.php');
include('classes/PlayerStats.php');
include('Config.php');


class Player extends Model
{
    /**
     * Table name
     * @var string
     */
    protected static $tableName = 'roster';

    /**
     * @param array $filters
     * @return \Tightenco\Collect\Support\Collection
     */
    public static function getPlayers(array $filters = []) {
        $players = sprintf('`%s`', self::getTableName());

        $sql = <<<END
        SELECT $players.*
        FROM $players
END;
        //TODO:needs refactor
        if (array_key_exists('playerId', $filters)) {
            $sql .= " WHERE $players.id = ?";
        }

        if (array_key_exists('player', $filters)) {
            $sql .= " WHERE $players.name = ?";
        }

        if (array_key_exists('team', $filters)) {
            $sql .= " WHERE $players.team_code = ?";
        }

        if (array_key_exists('position', $filters)) {
            $sql .= " WHERE $players.pos = ?";
        }

        if (array_key_exists('country', $filters)) {
            $sql .= " WHERE $players.nationality = ?";
        }

        $pst = DB::getInstance()->prepare($sql);

        if (array_key_exists('playerId', $filters)) {
            $pst->bindValue(1, $filters['playerId'], PDO::PARAM_STR);
        }

        if (array_key_exists('player', $filters)) {
            $pst->bindValue(1, $filters['player'], PDO::PARAM_STR);
        }

        if (array_key_exists('team', $filters)) {
            $pst->bindValue(1, $filters['team'], PDO::PARAM_STR);
        }

        if (array_key_exists('position', $filters)) {
            $pst->bindValue(1, $filters['position'], PDO::PARAM_STR);
        }

        if (array_key_exists('country', $filters)) {
            $pst->bindValue(1, $filters['country'], PDO::PARAM_STR);
        }

        $pst->execute();

        return collect($pst->fetchAll())->map(function($item, $key) {
            unset($item['0']);
            unset($item['1']);
            unset($item['2']);
            unset($item['3']);
            unset($item['4']);
            unset($item['5']);
            unset($item['6']);
            unset($item['7']);
            unset($item['8']);
            unset($item['9']);
            unset($item['10']); //TODO:needs refactor
            return $item;
        });
    }
}