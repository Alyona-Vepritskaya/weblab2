<div class="right-col">
    <script src="validate_form.js"></script>
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
        <div class="form" >
            <form action="" class="qwerty" onsubmit="return submitForm()" method="post">
                <div id="pain"></div>
                <div class="block">
                    Логин:
                    <input id="login" type="text" required pattern="[^ ]">
                </div>
                <div class="block">
                    Пароль:
                    <input name="p1"  id="psw1" type="password" minlength="4"
                            placeholder="введите пароль" required>
                    <input name="p2" id="psw2" type="password" minlength="4"
                           placeholder="повторите пароль" required>
                </div>
                <div class="block">
                    Email:
                    <input id="email" type="email" required>
                </div>
                <div class="block">
                    <input class="submit" type="submit">
                </div>
            </form>
        </div>
    </div>
