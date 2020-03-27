<?php
include_once 'MyDB.php';
include_once 'connect-inc.php';
include_once 'create_tables.php';
/*include_once 'xml_parse.php';*/
// ------------ connect to db ------------
$mysqli = MyDB::get_db_instance();
// ------------- create struct -----------
create_struct($mysqli);
// ------------- insert data from xml -----------
$mysqli->close();
