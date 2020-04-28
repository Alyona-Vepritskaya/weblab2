<?php
include_once '../inc/connect-inc.php';
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

    public static function delete_me($mysqli,$table_name,$field_name,$field_value){
        $sql_del = "delete from $table_name where $field_name = '$field_value';";
        if ($mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $mysqli->error;
        }
    }

}