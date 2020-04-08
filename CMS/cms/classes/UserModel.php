<?php
include_once '../../classes/MyDB.php';
include_once '../../inc/connect-inc.php';

class UserModel
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
        $this->users = array();
        $sql_select = "select * from " . DBT_USERS . ";";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = array();
                $user['login'] = $row["login"];
                $user['id'] = $row["id"];
                $this->users[] = $user;
            }
        }
        return $this->users;
    }

    public function getUser($u_id)
    {
        $this->user = array();
        $sql_select = "select * from " . DBT_USERS . " where id='" . $u_id . "';";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->user['login'] = $row["login"];
                $this->user['id'] = $row["id"];
            }
        }
        return $this->user;
    }

    public function getUserByFields($login)
    {
        $u_id = 0;
        $sql_select = "select * from " . DBT_USERS . " where login='$login';";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $u_id = $row["id"];
            }
        }
        return $u_id;
    }

    public function updateUser($u_id, $u_login, $_psw)
    {
        $sql_update = "update " . DBT_USERS . "
        set login   = '" . $u_login . "',
            password = PASSWORD('" . $_psw . "')
        where id = '" . $u_id . "';";
        if ($this->mysqli->query($sql_update) !== true) {
            echo "Error updating record: " . $this->mysqli->error;
        }
    }

    public function deleteUser($u_id)
    {
        $sql_del = "delete from " . DBT_USERS . " where id='" . $u_id . "';";
        if ($this->mysqli->query($sql_del) !== TRUE) {
            echo "Error: " . $sql_del . "<br>" . $this->mysqli->error;
        }
    }

    public function addUser($u_login, $_psw)
    {
        $sql_insert = "insert into " . DBT_USERS . " (login, password)
         values ('$u_login',PASSWORD('$_psw'));";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }
    }

}