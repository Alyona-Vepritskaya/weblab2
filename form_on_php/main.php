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
            <form action="index.php" class="qwerty" method="post">
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