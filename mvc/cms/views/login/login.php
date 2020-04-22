<?php

$login = $this->login;
$error_message = $this->error_message;

///////////////////////////////////////// MAKE PAGE LAYOUT ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log In</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/io.css">
</head>
<body>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <h2 class="active">Sign In</h2>
        <h2 class="inactive underlineHover">Sign Up</h2>
        <form action="index.php" method="post">
            <input type="hidden" name="controller" value="LoginController">
            <input type="hidden" name="action" value="login">
            <?=$error_message?>
            <input type="text" id="login" class="fadeIn second" name="login" placeholder="login" value="<?=$login?>">
            <input type="password" id="password" class="fadeIn third" name="pwd" placeholder="password">
            <input type="submit" class="buy-item" value="Log In">
        </form>
    </div>
</div>
</body>
</html>
