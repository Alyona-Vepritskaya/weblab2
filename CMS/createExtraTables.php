<?php
include_once 'inc/connect-inc.php';
include_once "classes/MyDB.php";

function create_extra_tables($mysqli)
{
    //sql to drop tables
    $sql_drop0 = "drop table if exists " . DBT_USERS . ";";
    $sql_drop1 = "drop table if exists " . DBT_USERS_SESSIONS . ";";
    $sql_drop2 = "drop table if exists " . DBT_NEWS . ";";
    $sql_drop3 = "drop table if exists " . DBT_PAGES . ";";

    if ($mysqli->query($sql_drop0) !== true) {
        echo "Error dropping table: " . $mysqli->error;
    }
    if ($mysqli->query($sql_drop1) !== true) {
        echo "Error dropping table: " . $mysqli->error;
    }
    if ($mysqli->query($sql_drop2) !== true) {
        echo "Error dropping table: " . $mysqli->error;
    }
    if ($mysqli->query($sql_drop3) !== true) {
        echo "Error dropping table: " . $mysqli->error;
    }

    // sql to create tables
    $sql0 = "create table " . DBT_USERS . "
    (
        id       int primary key auto_increment,
        login    varchar(100) not null unique,
        password varchar(100) not null
    );";
    $sql1 = "create table " . DBT_USERS_SESSIONS . "
    (
        id          int primary key auto_increment,
        user_id     int         not null,
        ses_id      varchar(80) not null,
        add_date    datetime    not null,
        last_access datetime
    );";
    $sql2 = "create table " . DBT_NEWS . "
    (
        id             int primary key auto_increment,
        url            varchar(80) not null,
        name           varchar(50) not null,
        content        text        not null,
        published_date datetime
    );";
    $sql3 = "create table " . DBT_PAGES . "
    (
        id             int primary key auto_increment,
        url            varchar(80) not null,
        name           varchar(50) not null,
        content        text        not null,
        published_date datetime
    );";

    if ($mysqli->query($sql0) !== true) {
        echo "Error creating table: " . $mysqli->error;
    }
    if ($mysqli->query($sql1) !== true) {
        echo "Error creating table: " . $mysqli->error;
    }
    if ($mysqli->query($sql2) !== true) {
        echo "Error creating table: " . $mysqli->error;
    }
    if ($mysqli->query($sql3) !== true) {
        echo "Error creating table: " . $mysqli->error;
    }
}

$mysqli = MyDB::get_db_instance();
create_extra_tables($mysqli);
