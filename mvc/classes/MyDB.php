<?php
include_once '../inc/connect-inc.php';

/**
 * The Singleton MyDB class
 */
class MyDB
{
    private static $mysqli = null;

    public static function get_db_instance()
    {
        if (is_null(self::$mysqli)) {
            self::$mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        }
        return self::$mysqli;
    }

    public static function query_select($sql)
    {
        $data = Array();

        if( !is_null(self::$mysqli) )
        {
            if( $res = self::$mysqli->query($sql) )
            {
                while( $row = $res->fetch_assoc() )
                {
                    $data[] = $row;
                }
                $res->free();
            }
        }
        return $data;
    }

    public static function query_add_del_upd($sql)
    {
        if( !is_null(self::$mysqli) )
        {
            if( $res = self::$mysqli->query($sql) !== true ) {
                echo "Error !!!";
            }
        }
    }
}