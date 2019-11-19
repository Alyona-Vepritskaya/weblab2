<?php
$login = $_POST['login'];
$psw1 = $_POST['psw1'];
$psw2 = $_POST['psw2'];
$email = $_POST['email'];
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
    if (!(isIncorrect($psw1, 4) && isIncorrect($psw2, 4) &&
        isIncorrect($login, 0) && emailIsValid($email))) {
        $error = 'Запони форму правильно!!!';
        return $error;
    } elseif ($psw2 != $psw1) {
        $error = 'Пароли не совпадают!!!';
        return $error;
    } else {
        return $error;
    }
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Web_lab2</title>
</head>
<body>
<header class="head">
    <div class="logo">
        <div>
            <a href="">
                <img src="../images/Smart.png" alt="SMART">
            </a>
        </div>
        computers & mobile
    </div>
</header>
<main class="main-content">
    <div class="left-col">
        <img class="imggg" src="../images/header_bckgr.png" alt="">
        <div class="navigation-bar">
            <div class="item">
                <a href="index.php">
                    <img src="../images/more.png" alt=">">
                    Главная
                </a>
            </div>
            <div class="item">
                <a href="index.php">
                    <img src="../images/more.png" alt=">">
                    Регистрация
                </a>
            </div>
            <div class="item">
                <a href="../redirect_page/index.html">
                    <img src="../images/more.png" alt=">">
                    Редирект
                </a>
            </div>
            <div class="item">
                <a href="../animation/index.html">
                    <img src="../images/more.png" alt=">">
                    Анимация
                </a>
            </div>
            <div class="item">
                <a href="#">
                    <img src="../images/more.png" alt=">">
                    O компании
                </a>
            </div>

            <div class="item">
                <a href="#">
                    <img src="../images/more.png" alt=">">
                    Ссылки
                </a>
            </div>
            <div class="item">
                <a href="#">
                    <img src="../images/more.png" alt=">">
                    Ссылки 2
                </a>
            </div>
            <div>
                <img src="../images/left-frame3.png" alt="">
            </div>
        </div>
        <div class="items-container">
            <a href="#">
                <div class="new-items">
                    Новинки
                </div>
            </a>
            <div class="item-image">
                <a href="#">
                    <img src="../images/Layer_comer.png" alt="comer">
                    <div class="link">
                        Comer SP-2001
                    </div>
                </a>
                <a href="">
                    <img src="../images/Layer_mouse.png" alt="mouse">
                    <div class="link">
                        BenQ M301
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="right-col">
        <div class="news-info">
            <a href="">
                <div class="news">
                    Новости
                </div>
            </a>
            <div class="date">
                30 февраля 1313
            </div>
        </div>
        <div class="text-content  clearfix">
            <div class="form">
                <form action="index.php" class="qwerty" method="post">
                    <div id="pain">
                        <?php if (!empty(submitForm($psw1, $psw2, $login, $email, $error)!='')) {?>
                        <?php  echo submitForm($psw1, $psw2, $login, $email, $error)?>
                            <?php  } ?>
                    </div>
                    <div class="block">
                        Логин:
                        <input id="login" type="text" name="login" value ="<?php echo htmlspecialchars($login)?>">
                    </div>
                    <div class="block">
                        Пароль:
                        <input id="psw1" type="password" name="psw1"
                               placeholder="введите пароль" value ="<?php echo htmlspecialchars($psw1)?>">
                        <input id="psw2" type="password" name="psw2"
                               placeholder="повторите пароль" value ="<?php echo htmlspecialchars($psw2)?>">
                    </div>
                    <div class="block">
                        Email:
                        <input id="email" type="text" name="email" value ="<?php echo htmlspecialchars($email)?>">
                    </div>
                    <div class="block">
                        <input class="submit" type="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="foot">
        <img src="../images/foot.png" alt="">
    </div>
</footer>
</body>
</html>

