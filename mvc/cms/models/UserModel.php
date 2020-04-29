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

        return $u_id;
    }

    public function updateUser($id, $u_login, $_psw, $name)
    {
        $data = array('name' => $name,'login'=>$u_login,'password'=>"PASSWORD($_psw)");
        MyDB::update_me($this->mysqli, DBT_USERS, $data,'id',$id,'pwd');
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