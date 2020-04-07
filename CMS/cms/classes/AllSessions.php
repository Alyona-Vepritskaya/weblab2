<?php

class AllSessions
{
    private $ses_id;

    public function __construct($path = ''){
        session_start();
        $this->ses_id = session_id();
    }

    public function getSesId(){
        return $this->ses_id;
    }
}