<?php
include_once "classes/Sessions.php";
include_once "classes/UserSessions.php";
include_once "classes/UserModel.php";
include_once "../classes/MyDB.php";
include_once "../inc/filter_input_.php";

$s = new Sessions();
$s_id = $s->getSesId();
function check()
{
    $f = filter_input_('hidden_input', '');
    if ($f == 'omg') {
        return true;
    }
    return false;
}

$password = filter_input_('password', '');
$login = filter_input_('login', '');

//check form submit
//TODO
/*if (check()) {
    $mysqli = MyDB::get_db_instance();
    if (!empty($password) && !empty($login)) {
        $user = new UserModel($mysqli);
        if ($user->getUserByFields($login) != 0) {
            //user exist with this login exist
        } else {
            //create user
            $user->addUser($login,$password);
            //get id
            $u_id = $user->getUserByFields($login);
            //create session
            $u_ses = new UserSessions();
            $u_ses->makeUserAuth($u_id,$u_ses->getSesId());
            header('Location: http://k503labs.ukrdomen.com/535a/Veprytskaya/CMS/cms/home.php');
        }
    }
}*/
header('Location: http://k503labs.ukrdomen.com/535a/Veprytskaya/CMS/cms/home.php');
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
        <!-- Tabs Titles -->
        <h2 class="active">Sign In</h2>
        <h2 class="inactive underlineHover">Sign Up</h2>
        <!-- Login Form -->
        <form action="" method="post">
            <input type="hidden" name="hidden_input" value="omg">
            <input type="text" id="login" class="fadeIn second" name="login" placeholder="login">
            <input type="text" id="password" class="fadeIn third" name="password" placeholder="password">
            <input type="submit" class="buy-item" value="Log In">
        </form>
    </div>
</div>
</body>
</html>