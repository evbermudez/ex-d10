<?php

abstract class Model {
    protected static $tableName = null;

    /**
     * @return void|null
     */
    protected static function getTableName() {
        if (!empty(static::$tableName)) {
            return static::$tableName;
        }

        ob_clean();
        die('MODEL: Table does not exist.');
    }
}