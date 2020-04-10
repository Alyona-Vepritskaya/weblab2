<?php
include 'init.php';

$mysqli = MyDB::get_db_instance();
$session = new Sessions();
$ses_id = $session->getSesId();
$user_session = new UserSessions();
$action = filter_input_('action', '');
if ($action == 'logout') {
    $user_session->deleteUserAuth($ses_id);
}
$error_message = null;
$user = new UserModel($mysqli);
if ($user_session->checkUserAuth() != 0) {
    header('Location: http://k503labs.ukrdomen.com/535a/Veprytskaya/CMS/cms/home.php');
} else {
    //create record in session table
    $password = filter_input_('pwd', '');
    $login = filter_input_('login', '');
    if (!empty($password) && !empty($login)) {
        if ($user->getUserByLogin($login) != 0) {
            $u_id = $user->checkUser($login, $password);
            if ($u_id != 0) {
                $user_session->makeUserAuth($u_id, $ses_id);
                header('Location: http://k503labs.ukrdomen.com/535a/Veprytskaya/CMS/cms/home.php');
            } else {
                $error_message = 'Incorrect password';
            }
        } else {
            $error_message = 'Permission denied';
        }
    }
}
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
            <input type="hidden" name="hidden_input" value="omg">
            <?=$error_message?>
            <input type="text" id="login" class="fadeIn second" name="login" placeholder="login">
            <input type="password" id="password" class="fadeIn third" name="pwd" placeholder="password">
            <input type="submit" class="buy-item" value="Log In">
        </form>
    </div>
</div>
</body>
</html>