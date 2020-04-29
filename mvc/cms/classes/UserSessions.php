<?php
include '../init.php';

class UserSessions extends Sessions
{
    private $mysqli;
    private $user_id;

    public function __construct($path = '')
    {
        $this->mysqli = MyDB::get_db_instance();
        parent::__construct($path);
    }

    public function checkUserAuth()
    {
        $field_names = array('user_id');
        $u = MyDB::select_me($this->mysqli, DBT_USERS_SESSIONS, 'ses_id', $this->getSesId(), $field_names);

        $this->user_id =(is_null($u))? 0:$u['user_id'];

        return $this->user_id;
    }

    public function makeUserAuth($user_id, $ses_id)
    {
        $data = array('user_id' => $user_id, 'ses_id' => $ses_id, 'last_access' => 'NOW()', 'add_date' => 'CURDATE()');
        MyDB::add_me($this->mysqli, DBT_USERS_SESSIONS, $data,'datetime');
    }

    public function deleteUserAuth($ses_id)
    {
        MyDB::delete_me($this->mysqli, DBT_USERS_SESSIONS, 'ses_id', $ses_id);
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}