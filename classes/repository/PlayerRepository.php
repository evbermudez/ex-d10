<?php

include('classes/DB.php');

class PlayerRepository implements PlayerRepositoryInterface
{
    public function getPlayer(array $filters = [])
    {
        $tableName = sprintf('`%s`', self::$tableName);

        $sql = <<<END
        SELECT roster.*
        FROM roster
END;
        $pst = DB::getInstance()->prepare($sql);
        $pst->execute();

        return $pst->fetch();
    }
}