<?php
include '../init.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href=<?=SITE_HOST."cms/css/style.css"?>>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu|Ubuntu+Mono&display=swap" rel="stylesheet">
    <title>MVC</title>
</head>
<body>
<ul>
    <li><a href="<?= Controller::formatUrl('HomeController')?>">Home</a></li>
    <li><a href="<?= Controller::formatUrl('NewsController')?>">News</a></li>
    <li><a href="<?= Controller::formatUrl('ProductsController')?>">Products</a></li>
    <li><a href="<?= Controller::formatUrl('UsersController')?>">Users</a></li>
    <li><a href="<?= Controller::formatUrl('PagesController')?>">Pages</a></li>
    <li><a href="<?= Controller::formatUrl('CommentsController')?>">Comments</a></li>
    <li><a href="<?= Controller::formatUrl('SectionsController')?>">Sections</a></li>
    <li><a href="<?= Controller::formatUrl('LoginController','logout')?>">Log out</a></li>
</ul>

