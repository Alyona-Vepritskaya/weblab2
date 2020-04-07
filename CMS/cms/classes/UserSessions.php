<?php
include "Sessions.php";


class UserSessions extends Sessions
{
    private $user_id;
    public $is_auth;

    public function __construct($path = ''){
        parent::__construct($path);
        $this->is_auth = false;
        $this->user_id = $this->checkUserAuth();
        if ($this->user_id != 0) {
            $this->is_auth = true;
        }
    }

    public function checkUserAuth()
    {

    }

    public function makeUserAuth()
    {

    }

    public function checkUser($login, $password)
    {

    }
}