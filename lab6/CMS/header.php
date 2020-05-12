<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Galetinko</title>
    <link rel="stylesheet" href="Stylesheet.css">
<title>
  <?php 
if(isset($title) && !empty($title)) { 
   echo $title; 
} 
else { 
   echo "Default title tag"; 
} ?></title>
</head>
<body>

<div class="back">
    <header>
        <div>
                <div>
                    <img id="train" alt="" src="picture/ball.jpg">
                </div>
        </div>
        <nav>
            <span><a href="home_page.php" class="span_head">HOME PAGE</a></span>
            <span><a href="news_page.php" class="span_head">NEWS</a></span>
            <span><a href="" class="span_head">PLAYERS</a></span>
            <span><a href="server.php" class="span_head">SERVER</a></span>
            <span><a href="products.php" class="span_head">PRODUCTS</a></span>
            <span><a href="" class="span_head">MANAGE</a></span>
            <span><a href="" class="span_head">CONSOLE</a></span>
            <span><a href="" class="span_head">SPONSORS</a></span>
            <span><a href="" class="span_head">TICKETS</a></span>
            <span class="space">&#160;</span>
        </nav>
    </header>