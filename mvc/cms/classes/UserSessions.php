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
        $sql_fields = 'user_id';
        $id = $this->getSesId();

        $sql = "SELECT $sql_fields FROM " . DBT_USERS_SESSIONS . " where ses_id = '$id'";
        $u = MyDB::query_select($sql);

        if (count($u) > 0) {
            $u = $u[0];
        }

        $this->user_id = (is_null($u)) ? 0 : $u['user_id'];
        $this->user_id = (is_null($u)) ? 0 : $u['user_id'];
        return $this->user_id;
    }

    public function makeUserAuth($user_id, $ses_id)
    {
        $field_names = implode(", ", array('user_id', 'ses_id', 'last_access', 'add_date'));
        $field_values = implode(", ", array("'$user_id'", "'$ses_id'", 'NOW()', "CURDATE()"));

        $sql_insert = "insert into " . DBT_USERS_SESSIONS . " ($field_names) values ($field_values);";

        MyDB::query_add_del_upd($sql_insert);
    }

    public function deleteUserAuth($ses_id)
    {
        $fldname = 'ses_id';
        $sql_del = "delete from " . DBT_USERS_SESSIONS . " where $fldname = '$ses_id';";
        MyDB::query_add_del_upd($sql_del);
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}