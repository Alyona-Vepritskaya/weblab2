<?php
include_once '../init.php';

class UserModel extends Model
{
    private $mysqli;
    private $user;
    private $users;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getUser($id)
    {
        $field_names = array("login", "id","name");
        $this->user = $this->getUsers('id', "'$id'",$field_names);

        if(count($this->user)==1){
            $this->user = $this->user[0];
        }

        return $this->user;
    }

    public function getUsers($fldname = "", $fldvalue = "", $fields = null, $sortby = "id", $pi = -1, $pn = 20)
    {

        $sql_sort = " id ";

        switch ($sortby) {
            case "name":
                $sql_sort = "name";
                break;

            case "add":
                $sql_sort = "add_date";
                break;
        }

        $sql_fields = " * ";

        if ($fields != null) {
            $sql_fields = implode(", ", $fields);
        }

        $sql_limit = "";

        if ($pi >= 0) {
            $sql_limit = " LIMIT " . ($pi * $pn) . ", " . $pn . " ";
        }

        $sql_cond = "";
        if ($fldname != "") {
            $sql_cond = " WHERE $fldname = $fldvalue";
        }
        $sql = "SELECT " . $sql_fields . " FROM " . DBT_USERS . " " . $sql_cond . " ORDER BY " . $sql_sort . " " . $sql_limit;

        $this->users = MyDB::query($sql);

        return $this->users;
    }

    public function getUserByLogin($login)
    {
        $this->user = $this->getUsers('login', "'$login'");

        if(count($this->user)==1){
            $this->user = $this->user[0];
        }

        $u_id = !(is_null($this->user)) ? $this->user['id'] : 0;
        return $u_id;
    }

    public function checkUser($login, $pwd)
    {
        //TODO
        $field_names = array('id');
        $tmp = MyDB::hard_select_me($this->mysqli, DBT_USERS, 'login', 'password',
            $login, "PASSWORD('$pwd')", $field_names);

        $u_id = (is_null($tmp)) ? 0 : $tmp['id'];

        return $u_id;
    }

    public function updateUser($id, $u_login, $_psw, $name, $field_name='id')
    {
        $data = array('name' => "'$name'",'login'=>"'$u_login'",'password'=>"PASSWORD('$_psw')");

        $field_names_values = '';
        foreach ($data as $key => $value) {
            $field_names_values .= " $key = $value,";
        }
        $field_names_values = substr($field_names_values, 0, -1);
        $sql_update = "update ".DBT_USERS." set $field_names_values  where $field_name = '$id';";

        MyDB::query_add_del_upd($sql_update);
    }

    public function deleteUser($fldvalue, $fldname='id')
    {
        $sql_del = "delete from ".DBT_USERS. " where $fldname = '$fldvalue';";
        MyDB::query_add_del_upd($sql_del);
    }

    public function addUser($login, $password, $name)
    {
        $field_names = implode(", ", array('login','password','name'));
        $field_values = implode(", ", array("'$login'","PASSWORD('$password')","'$name'"));

        $sql_insert = "insert into ".DBT_USERS." ($field_names) values ($field_values);";

        MyDB::query_add_del_upd($sql_insert);
    }
}