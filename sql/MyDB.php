<?php
include_once 'connect-inc.php';
/**
 * The Singleton MyDB class
 */
class MyDB {
    private static $mysqli = null;

    public static function get_db_instance()
    {
        if(is_null(self::$mysqli)){
            self::$mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        }
        return self::$mysqli;
    }

}