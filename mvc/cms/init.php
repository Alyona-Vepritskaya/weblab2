<?php
include_once "../inc/connect-inc.php";
include_once "../inc/filter_input_.php";
include_once '../classes/MyDB.php';

spl_autoload_register(function ($class_name){
    $inc_file = $class_name . '.php';
    if (file_exists('models/' .$inc_file))
        include_once 'models/' .$inc_file;
    else if (file_exists("controllers/" . $inc_file))
        include_once "controllers/" . $inc_file;
    else if (file_exists("classes/" . $inc_file))
        include_once "classes/" . $inc_file;
});

$mysqli = MyDB::get_db_instance();