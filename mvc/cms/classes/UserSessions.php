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
        $this->user_id = 0;
        $sql_select = "select * from " . DBT_USERS_SESSIONS . " where ses_id='" . $this->getSesId() . "';";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->user_id = $row['user_id'];
            }
        }
        return $this->user_id;
    }

    public function makeUserAuth($user_id, $ses_id)
    {
        $data = array('user_id' => $user_id, 'ses_id' => $ses_id, 'last_access' => 'NOW()', 'add_date' => 'CURDATE()');
        MyDB::add_me($this->mysqli, DBT_USERS_SESSIONS, $data,'datetime');

       /* $sql_insert = "insert into " . DBT_USERS_SESSIONS . " (user_id, ses_id, last_access, add_date)
         values ('$user_id','$ses_id',NOW(),CURDATE());";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }*/
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