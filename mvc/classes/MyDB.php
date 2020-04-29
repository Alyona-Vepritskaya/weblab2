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

    public static function hard_select_me($mysqli, $table_name, $field_name1, $field_name2, $field_value1, $field_value2, $field_names)
    {
        $item = null;

        $sql_select = "select * from $table_name where $field_name1 = '$field_value1' and $field_name2 = $field_value2;";
        $result = $mysqli->query($sql_select);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                foreach ($field_names as $k => $v)
                    $item[$v] = $row[$v];
            }
        }

        return $item;
    }

    public static function select_me($mysqli, $table_name, $field_name, $field_value, $field_names)
    {
        $item = null;

        $sql_select = "select * from $table_name where $field_name = '$field_value'";
        $result = $mysqli->query($sql_select);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                foreach ($field_names as $k => $v)
                    $item[$v] = $row[$v];
            }
        }

        return $item;
    }

    public static function select_all_of_me($mysqli, $table_name, $field_name, $field_value, $field_names)
    {
        $items = null;

        $sql_select = "select * from $table_name where $field_name = '$field_value'";
        $result = $mysqli->query($sql_select);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = array();
                foreach ($field_names as $k => $v)
                    $item[$v] = $row[$v];
                $items[] = $item;
            }
        }

        return $items;
    }

    public static function global_select_me($mysqli, $table_name, $field_names)
    {
        $items = null;

        $sql_select = "select * from $table_name ;";
        $result = $mysqli->query($sql_select);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = array();
                foreach ($field_names as $k => $v)
                    $item[$v] = $row[$v];
                $items[] = $item;
            }
        }

        return $items;
    }

    public static function delete_me($mysqli, $table_name, $field_name, $field_value)
    {
        $sql_del = "delete from $table_name where $field_name = '$field_value';";
        if ($mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $mysqli->error;
        }
    }

    public static function add_me($mysqli, $table_name, $data, $f = null)
    {

        if ($f == 'pwd') {
            $without_quotes = $data['password'];
        } elseif ($f == 'date') {
            $without_quotes = 'CURDATE()';
        } elseif ($f == 'datetime') {
            $without_quotes = 'CURDATE() NOW()';
        } else {
            $without_quotes = '';
        }

        $field_names = '';
        $field_values = '';

        if (empty($without_quotes)) {
            foreach ($data as $key => $value) {
                $field_names .= $key . ',';
                $field_values .= '\'' . $value . '\',';
            }
        } else {
            foreach ($data as $key => $value) {
                $field_names .= $key . ',';
                $field_values .= (strrpos($without_quotes, $value) === false) ? '\'' . $value . '\',' : $value . ',';
            }
        }

        $field_names = substr($field_names, 0, -1);
        $field_values = substr($field_values, 0, -1);

        $sql_insert = "insert into $table_name ($field_names) values ($field_values);";

        if ($mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $mysqli->error;
        }
    }

}