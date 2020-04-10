<?php
include_once "../inc/connect-inc.php";
include_once "../classes/MyDB.php";
include_once "../inc/filter_input_.php";
function my_autoloader($class_name){
    include_once 'classes/' . $class_name . '.php';
}
spl_autoload_register('my_autoloader');