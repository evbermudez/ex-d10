<?php

/**
 * Database Class for Connection
 */
class DB
{
    /**
     * Handler
     * @var PDO|null
     */
    private static $dbHandler = null;

    /**
     * Connects to DB server and returns an instance of the PDO handler
     * @return PDO
     */
    public static function getInstance() {
        if(self::$dbHandler === null) {
            //data source name
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', Config::DB_HOSTNAME, Config::DB_NAME);

            try {
                self::$dbHandler = new PDO($dsn, Config::DB_USERNAME, Config::DB_PASSWORD, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
                ]);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                ob_clean();
                die('DATABASE: Connection Error.');
            }
        }
        return self::$dbHandler;
    }
}