<?php

$name = $this->name;
$login = $this->login;

///////////////////////////////////////// MAKE PAGE LAYOUT ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<div class="form-inside">
    <form class="f1" action="<?= Controller::formatUrl('UsersController', 'add')?>" method="post">
        <!--<input type="hidden" name="controller" value="UsersController">
        <input type="hidden" name="action" value="add">-->
        Name
        <input value="<?=$name?>" required type="text" class="fadeIn second" name="name" placeholder="">
        Login
        <input value="<?=$login?>" required type="text" class="fadeIn second" name="login" placeholder="">
        Password
        <input required type="password" class="fadeIn second" name="password" placeholder="">
        <input required type="password" class="fadeIn second" name="password2" placeholder="">
        <input type="submit" class="buy-item" value="Add User">
    </form>
</div>
