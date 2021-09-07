<?php

class PlayerStats extends Model
{
    /**
     * Table name
     * @var string
     */
    protected static $tableName = 'player_totals';

    /**
     * @param array|null $filters
     * @return array|false
     */
    public static function getPlayersStats(array $filters = null) {
        $players = sprintf('`%s`', Player::getTableName());
        $playerTotals = sprintf('`%s`', self::getTableName());

        $sql = <<<END
        SELECT $players.*, $playerTotals.*
        FROM $playerTotals
        INNER JOIN $players ON ($players.id = $playerTotals.player_id)
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

        return $pst->fetchAll();
    }
}