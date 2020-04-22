<?php
include_once 'inc/connect-inc.php';
include_once "inc/filter_input_.php";
include_once 'classes/MyDB.php'; //Redo

spl_autoload_register(function ($class_name){
   if (file_exists("cms/models/" . $class_name.'.php'))
        include_once "cms/models/" . $class_name.'.php';
});

$mysqli = MyDB::get_db_instance();