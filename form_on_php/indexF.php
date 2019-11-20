<?php

$login = filter_input(INPUT_POST, 'login');
$psw1 = filter_input(INPUT_POST, 'psw1');
$psw2 = filter_input(INPUT_POST, 'psw2');
$email = filter_input(INPUT_POST, 'email');
$error = '';

function isIncorrect($value, $originValue)
{
    return strlen($value) > $originValue;
}

function emailIsValid($email)
{
    return preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+$/", $email);
}

function submitForm($psw1, $psw2, $login, $email, $error)
{
    if (!(isIncorrect($psw1, 0) && isIncorrect($psw2, 0) &&
        isIncorrect($login, 0) && emailIsValid($email))) {
        $error = 'Запони форму правильно!!!';

        return $error;
    } elseif ($psw2 != $psw1) {
        $error = 'Пароли не совпадают!!!';
        return $error;
    } else {
        // $error = '';
        return $error;
    }

}

?>
<?php include '../general/header.php' ?>
        <div class="text-content  clearfix">
            <div class="form">
                <form action="indexF.php" class="qwerty" method="post">
                    <div id="pain">
                        <?php if (submitForm($psw1, $psw2, $login, $email, $error) != '') { ?>
                            <?php echo submitForm($psw1, $psw2, $login, $email, $error) ?>
                        <?php } ?>
                    </div>
                    <div class="block">
                        Логин:
                        <input id="login" type="text" name="login"
                               value="<?php if (submitForm($psw1, $psw2, $login, $email, $error) != '') echo htmlspecialchars($login) ?>">
                    </div>
                    <div class="block">
                        Пароль:
                        <input id="psw1" type="password" name="psw1"
                               placeholder="введите пароль"
                               value="<?php if (submitForm($psw1, $psw2, $login, $email, $error) != '') echo htmlspecialchars($psw1) ?>">
                        <input id="psw2" type="password" name="psw2"
                               placeholder="повторите пароль"
                               value="<?php if (submitForm($psw1, $psw2, $login, $email, $error) != '') echo htmlspecialchars($psw2) ?>">
                    </div>
                    <div class="block">
                        Email:
                        <input id="email" type="text" name="email"
                               value="<?php if (submitForm($psw1, $psw2, $login, $email, $error) != '') echo htmlspecialchars($email) ?>">
                    </div>
                    <div class="block">
                        <input class="submit" type="submit">
                    </div>
                </form>
            </div>
        </div>
   <?php include '../general/footer.php';

