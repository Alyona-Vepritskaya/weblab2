<?php
include_once '../init.php';

class View
{
    private $data;

    public function __construct(){
        $this->data = Array();
    }

    public function __get($fieldName){
        if (isset($this->data[$fieldName]))
            return $this->data[$fieldName];
        return null;
    }

    public function __set($fieldName, $fieldValue){
        $this->data[$fieldName] = $fieldValue;
    }

    public function __isset($fieldName){
        return isset($this->data[$fieldName]);
    }

    public function __unset($fieldName){
        if (isset($this->data[$fieldName]))
            unset($this->data[$fieldName]);
    }
}