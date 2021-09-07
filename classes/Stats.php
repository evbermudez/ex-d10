<?php
include('classes/Model.php');


class Stats extends Model
{
    /**
     * Table name
     * @var string
     */
    protected static $tableName = 'roster';

    public static function getByPlayer(array $filters = []) {
        $players = sprintf('`%s`', self::$tableName);
        $playerTotals = sprintf('`%s`', PlayerStats::getTableName());

        $sql = <<<END
        SELECT $players.*, $playerTotals.*
        FROM $playerTotals
        INNER JOIN $players ON ($players.id = $playerTotals.player_id)
END;

        $pst = DB::getInstance()->prepare($sql);
        $pst->execute();

        return $pst->fetchAll();
    }

    public static function getByPosition() {

    }
}