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

    public function getUsers()
    {
        $field_names = array('id', 'name', 'login');
        $this->users = MyDB::global_select_me($this->mysqli, DBT_USERS, $field_names);

        return $this->users;
    }

    public function getUser($id)
    {
        $field_names = array('login', 'id', 'name');
        $this->user = MyDB::select_me($this->mysqli, DBT_USERS, 'id', $id, $field_names);

        return $this->user;
    }

    public function getUserByLogin($login)
    {
        $field_names = array('id');
        $this->user = MyDB::select_me($this->mysqli, DBT_USERS, 'login', $login, $field_names);
        $u_id = !(is_null($this->user)) ? $this->user['id'] : 0;
        return $u_id;
    }

    public function checkUser($login, $pwd)
    {
        $field_names = array('id');
        $tmp = MyDB::hard_select_me($this->mysqli, DBT_USERS, 'login', 'password',
            $login, "PASSWORD('$pwd')", $field_names);

        $u_id = (is_null($tmp)) ? 0 : $tmp['id'];
        /*$sql_select = "select * from " . DBT_USERS . " where login='$login' and password=PASSWORD('$pwd');";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $u_id = $row["id"];
            }
        }*/
        return $u_id;
    }

    public function updateUser($id, $u_login, $_psw, $name)
    {
        $sql_update = "update " . DBT_USERS . "
        set login   = '" . $u_login . "',
            name   = '" . $name . "',
            password = PASSWORD('" . $_psw . "')
        where id = '" . $id . "';";
        if ($this->mysqli->query($sql_update) !== true) {
            echo "Error updating record: " . $this->mysqli->error;
        }
    }

    public function deleteUser($id)
    {
        MyDB::delete_me($this->mysqli, DBT_USERS, 'id', $id);
    }

    public function addUser($login, $password, $name)
    {
        $data = array('login' => $login, 'password' => "PASSWORD('$password')", 'name' => $name);
        MyDB::add_me($this->mysqli, DBT_USERS, $data, 'pwd');
    }
}