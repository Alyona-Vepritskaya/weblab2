<?php
function check()
{
    if (filter_input_('h_input', 'first') == 'first') {
        $_POST['h_input'] = 'second';
        return false;
    } else {
        return true;
    }
}

function filter_input_($name, $def)
{
    $result = $def;
    if (isset($_POST[$name])) {
        $result = $_POST[$name];
    }
    if (isset($_GET[$name])) {
        $result = $_GET[$name];
    }
    return $result;
}

$login = filter_input_('login', '');
$psw1 = filter_input_('psw1', '');
$psw2 = filter_input_('psw2', '');
$email = filter_input_('email', '');
$error = '';
function isIncorrect($value, $originValue)
{
    return strlen($value) > $originValue;
}

function emailIsValid($email)
{
    return preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+$/", $email);
}

if (!(isIncorrect($psw1, 3) && isIncorrect($psw2, 3) &&
    isIncorrect($login, 0) && emailIsValid($email))) {
    $error = 'Запони форму правильно!!!';
} elseif ($psw2 != $psw1) {
    $error = 'Пароли не совпадают!!!';
} else {
    $error = '';
}
?>

<div class="right-col">
    <div class="news-info">
        <a href="">
            <div class="news">
                Регистрация
            </div>
        </a>
        <div class="date">
            30 февраля 1313
        </div>
    </div>
    <div class="text-content  clearfix">
        <div class="form">
            <?php if ($error != '' || !check()) { ?>
                <form class="qwerty" method="post" id="form">
                    <input type="text" name="h_input" hidden="hidden">
                    <div id="pain">
                        <?php if ($error != '' && check()) {
                            echo $error;
                        } ?>
                    </div>
                    <div class="block">
                        Логин:
                        <input id="login" type="text" name="login"
                               value="<?php if ($error != '') echo $login ?>">
                    </div>
                    <div class="block">
                        Пароль:
                        <input id="psw1" type="password" name="psw1"
                               placeholder="введите пароль"
                               value="<?php if ($error != '') echo $psw1 ?>">
                        <input id="psw2" type="password" name="psw2"
                               placeholder="повторите пароль"
                               value="<?php if ($error != '') echo $psw2 ?>">
                    </div>
                    <div class="block">
                        Email:
                        <input id="email" type="text" name="email"
                               value="<?php if ($error != '') echo $email ?>">
                    </div>
                    <div class="block">
                        <input class="submit" type="submit">
                    </div>
                </form>
            <?php } else { ?>
                <div id="registered">
                    "Мои поздравления, ты зарегался!!! 🥳 "
                </div>
            <?php } ?>
        </div>
    </div>