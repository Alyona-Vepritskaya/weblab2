<?php
include_once 'connect-inc.php';
function create_struct($mysqli)
{
    //sql to drop tables
    $sql_drop = "drop table ".DBT_SECTIONS."; 
    drop table ".DBT_PARAM.";
    drop table ".DBT_PRODUCTS.";
    drop table ".DBT_REVIEWS.";";
    if ($mysqli->query($sql_drop) !== true) {
        echo "Error dropping table: " . $mysqli->error;
    }
    // sql to create tables
    $sql = "create table ".DBT_SECTIONS."
    (
        id   int primary key auto_increment,
        name varchar(30) not null unique
    );
    create table ".DBT_PRODUCTS."
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
    );
    create table ".DBT_PARAM."
    (
        id         int primary key auto_increment,
        name       varchar(100) not null,
        value      varchar(200) not null,
        id_product varchar(60)  not null
    );
    create table ".DBT_REVIEWS." //!!!
    (
        id         int primary key auto_increment,
        name       varchar(100) not null,
        email      varchar(50)  not null,
        comment    varchar(200) not null,
        id_product int          not null
    );";

    if ($mysqli->query($sql) !== true) {
        echo "Error creating table: " . $mysqli->error;
    }
}