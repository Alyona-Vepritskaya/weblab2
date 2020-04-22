<?php

$error_message = $this->error_message;
$info = $this->user;

///////////////////////////////////////// MAKE PAGE LAYOUT ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<div class="m-auto"><h4><?= $error_message ?></h4></div>
<div class="form-inside">
    <form class="f1" action="index.php" method="post">
        <input type="hidden" name="controller" value="UsersController">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= $info['id'] ?>">
        Name
        <input required type="text" class="fadeIn second" name="name" placeholder="" value="<?= $info['name'] ?>">
        Login
        <input required class="fadeIn second" type="text" name="login" value="<?= $info['login'] ?>">
        Password
        <input required name="password" class="fadeIn second" type="password" value="">
        <input required name="password2" class="fadeIn second" type="password" value="">
        <input type="submit" class="buy-item" value="Update">
    </form>
</div>
