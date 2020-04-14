<?php
include_once "../inc/connect-inc.php";
include_once "../inc/filter_input_.php";

function my_autoloader($class_name){
    $inc_file = 'classes/' . $class_name . '.php';
    if (file_exists($inc_file))
        include_once $inc_file;
    else if (file_exists("../" . $inc_file))
        include_once "../" . $inc_file;
}

spl_autoload_register('my_autoloader');

$u = new UserSessions();
$mysqli = MyDB::get_db_instance();