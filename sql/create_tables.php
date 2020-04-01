<?php
include_once 'connect-inc.php';
function create_struct($mysqli)
{
    $sql_select = "select * from " . DBT_REVIEWS . ";";
    $result = $mysqli->query($sql_select);

    //sql to drop tables
    $sql_drop2 = "drop table if exists " . DBT_SECTIONS . ";";
    $sql_drop1 = "drop table if exists " . DBT_PARAM . ";";
    $sql_drop0 = "drop table if exists " . DBT_PRODUCTS . ";";
    $sql_drop3 = "drop table if exists " . DBT_REVIEWS . ";";
    $sql_drop4 = "drop table if exists " . DBT_IMG . ";";

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
    if ($mysqli->query($sql_drop4) !== true) {
        echo "Error dropping table: " . $mysqli->error;
    }
    // sql to create tables
    $sql0 = "create table " . DBT_SECTIONS . "
     (
         id   int primary key auto_increment,
         name varchar(30) not null unique
     );";
    $sql1 = "create table " . DBT_PRODUCTS . "
     (
        id         int primary key auto_increment,
        name       varchar(60)  not null default '',
        s_num      varchar(60)  not null unique,
        price      decimal(10,2) not null,
        year       year         not null,
        country    varchar(60)  not null default '',
        img        varchar(100) not null,
        id_section int          not null,
        foreign key (id_section) references " . DBT_SECTIONS . " (id)
     );";
    $sql2 = "create table " . DBT_PARAM . "
     (
        id         int primary key auto_increment,
        name       varchar(100) not null,
        value      varchar(200) not null,
        sort       int          not null,
        id_product int          not null
    );";
    $sql3 = "create table " . DBT_REVIEWS . "
     (
        id         int primary key auto_increment,
        name       varchar(100) not null,
        email      varchar(50)  not null,
        comment    varchar(200) not null,
        id_product int          not null
     );";
    $sql4 = "create table " . DBT_IMG . "
    (
        id         int primary key auto_increment,
        name       varchar(100) not null,
        sort       int          not null,
        id_product int          not null
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
    if ($mysqli->query($sql4) !== true) {
        echo "Error creating table: " . $mysqli->error;
    }
    //rewrite comments
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $email = $row['email'];
            $comment = $row['comment'];
            $product_id = $row['id_product'];
            $sql_insert = "insert into " . DBT_REVIEWS . " (name, email, comment, id_product)
            values ('$name','$email','$comment','$product_id');";
            if ($mysqli->query($sql_insert) !== TRUE) {
                echo "Error: " . $sql_insert . "<br>" . $mysqli->error;
            }
        }
    }
}