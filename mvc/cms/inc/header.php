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
    <li><a href=<?=SITE_HOST."cms/home.php"?>>Home</a></li>
    <li><a href=<?=SITE_HOST."cms/news.php"?>>News</a></li>
    <li><a href=<?=SITE_HOST."cms/products.php"?>>Products</a></li>
    <li><a href=<?=SITE_HOST."cms/users.php"?>>Users</a></li>
    <li><a href=<?=SITE_HOST."cms/pages.php"?>>Pages</a></li>
    <li><a href=<?=SITE_HOST."cms/comments.php"?>>Comments</a></li>
    <li><a href=<?=SITE_HOST."cms/sections.php"?>>Sections</a></li>
    <li><a href=<?=SITE_HOST."cms/index.php?action=logout"?>>Log out</a></li>
</ul>

