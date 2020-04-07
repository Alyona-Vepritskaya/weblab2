<?php
include_once "classes/AllSessions.php";
include_once "classes/UserAllSessions.php";
include_once "classes/UserModel.php";
include_once "../classes/MyDB.php";

function check()
{
    $f = filter_input_('hidden_input', '');
    if ($f == 'omg') {
        return true;
    }
    return false;
}

function filter_input_($name, $default)
{
    $result = $default;
    if (isset($_POST[$name])) {
        $result = $_POST[$name];
    }
    if (isset($_GET[$name])) {
        $result = $_GET[$name];
    }
    return $result;
}
$password = filter_input_('password','');
$login = filter_input_('login','');
//check form submit
//TODO
/*if (check()) {
    $mysqli = MyDB::get_db_instance();
  //$session = new Sessions();
    $u_ses = new UserAllSessions();
    if (!empty($password) && !empty($login)) {
        if ($u_ses->checkUser($login, $password)) {
            //user exists
        }else{
            $user = new UserModel($mysqli);
            $user->addUser($login,$password);
            $u_ses->makeUserAuth($u_ses->getUserId(),session_id());
           //echo "dfghjk";
            header('Location: http://k503labs.ukrdomen.com/535a/Veprytskaya/CMS/cms/home.php');
        }
    }
}*/
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