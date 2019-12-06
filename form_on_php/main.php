<?php
$view = '';
function check()
{
    $f = filter_input_('hidden_input', '');
    if ($f == 'first') {
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

function isIncorrect($value, $originValue)
{
    return strlen($value) > $originValue;
}

function emailIsValid($email)
{
    return preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+$/", $email);
}

$login = trim(filter_input_('login', ''));
$psw1 = trim(filter_input_('psw1', ''));
$psw2 = trim(filter_input_('psw2', ''));
$email = trim(filter_input_('email', ''));
$error = '';

if (check()) {

    if (!(isIncorrect($psw1, 3) && isIncorrect($psw2, 3) &&
        isIncorrect($login, 0) && emailIsValid($email))) {
        $error = 'Запони форму правильно!!!';
    } elseif ($psw2 != $psw1) {
        $error = 'Пароли не совпадают!!!';
    } else {
        $error = '';
        $view = 'ok';
    }

}

?>
<?php include '../general/header.php'; ?>
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
        <?php
            if ($view == "")
            {
            ?>
                <form class="qwerty" method="POST" id="form" action="main.php">
                    <input type="hidden" name="hidden_input" value="first">
                    <?php if ($error != '')
                    {
                        echo "<div id=\"pain\">$error</div>";
                    }
                    ?>
                    <div class="block">
                        Логин:
                        <input id="login" type="text" name="login" value="<?=($login)?>">
                    </div>
                    <div class="block">
                        Пароль:
                        <input id="psw1" type="password" name="psw1" placeholder="введите пароль" value="">
                        <input id="psw2" type="password" name="psw2" placeholder="повторите пароль" value="">
                    </div>
                    <div class="block">
                        Email:
                        <input id="email" type="text" name="email" value="<?=($email)?>">
                    </div>
                    <div class="block">
                        <input class="submit" type="submit">
                    </div>
                </form>
        <?php
            }
            else
             {?>
                <div id="registered">
                    Мои поздравления, ты зарегистировался!!! 🥳
                </div>
         <?php
             }?>
        </div>
    </div>
<?php include '../general/footer.php'; ?>