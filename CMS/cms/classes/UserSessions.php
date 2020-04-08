<?php
include_once "Sessions.php";
include_once '../../classes/MyDB.php';

class UserSessions extends Sessions
{
    private $mysqli;
    private $user_id;
    public $is_auth;

    public function __construct($path = '')
    {
        $this->mysqli = MyDB::get_db_instance();
        parent::__construct($path);
       /* $this->is_auth = false;
        $this->user_id = $this->checkUserAuth();
        if ($this->user_id != 0) {
            $this->is_auth = true;
        }*/
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

    public function makeUserAuth($user_id,$ses_id)
    {
        $sql_insert = "insert into " . DBT_USERS_SESSIONS . " (user_id, ses_id, last_access, add_date)
         values ('$user_id','$ses_id',NOW(),CURDATE());";
        if ($this->mysqli->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $this->mysqli->error;
        }
    }

/*    public function checkUser($login, $password)
    {
        $sql_select = "select * from " . DBT_USERS . " where login='$login ' and password=PASSWORD('$password');";
        $result = $this->mysqli->query($sql_select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->user_id = $row['id'];
            }
            return true;
        }else{
            $this->user_id = 0;
            return false;
        }
    }*/

    public function getUserId()
    {
        return $this->user_id;
    }

}