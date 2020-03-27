<?php
include_once 'connect-inc.php';
function create_struct($mysqli)
{
    //sql to drop tables
    $sql_drop2 = "drop table if exists " . DBT_SECTIONS . ";";
    $sql_drop1 = "drop table if exists " . DBT_PARAM . ";";
    $sql_drop0 = "drop table if exists " . DBT_PRODUCTS . ";";
    $sql_drop3 = "drop table if exists " . DBT_REVIEWS . ";";

    if (($mysqli->query($sql_drop0) !== true) || ($mysqli->query($sql_drop1) !== true) ||
        ($mysqli->query($sql_drop2) !== true) || ($mysqli->query($sql_drop3) !== true)) {
        echo "Error dropping table: " . $mysqli->error;
    }
    // sql to create tables
    $sql0 = "create table ".DBT_SECTIONS."
     (
         id   int primary key auto_increment,
         name varchar(30) not null unique
     );";
    $sql1 = "create table ".DBT_PRODUCTS."
     (
         id         int primary key auto_increment,
         name       varchar(60)  not null,
         s_num      varchar(60)  not null unique,
         price      float        not null,
         year       year         not null,
         country    varchar(60)  not null,
         img        varchar(100) not null,
         id_section int          not null,
         foreign key (id_section) references ".DBT_SECTIONS." (id)
     );";
    $sql2 = "create table ".DBT_PARAM."
     (
         id         int primary key auto_increment,
         name       varchar(100) not null,
         value      varchar(200) not null,
         id_product varchar(60)  not null
     );";
    $sql3 = "create table ".DBT_REVIEWS."
     (
         id         int primary key auto_increment,
         name       varchar(100) not null,
         email      varchar(50)  not null,
         comment    varchar(200) not null,
         id_product varchar(60)  not null
     );";

    if (($mysqli->query($sql0) !== true) || ($mysqli->query($sql1) !== true) ||
        ($mysqli->query($sql2) !== true) ||($mysqli->query($sql3) !== true)) {
        echo "Error creating table: " . $mysqli->error;
    }
}