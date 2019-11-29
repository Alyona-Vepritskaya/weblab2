<div class="right-col">
    <div class="news-info">
        <a href="">
            <div class="news">
                Server
            </div>
        </a>
        <div class="date">
            30 февраля 1313
        </div>
    </div>
    <div class="text-content  clearfix">
        <div id="registered">
            Значения серверных переменных
            <p>
                <!--Переменная $_SERVER - это массив, содержащий информацию, такую как заголовки,
                пути и местоположения скриптов. Записи в этом массиве создаются веб-сервером.-->
                $_SERVER
                <?php print("<pre>" . print_r($_SERVER, true) . "</pre>"); ?>
                <!--Переменные HTTP POST-->
                $_POST
                <?php print("<pre>" . print_r($_POST, true) . "</pre>"); ?>
                <!--Переменные HTTP GET-->
                $_GET
                <?php print("<pre>" . print_r($_GET, true) . "</pre>"); ?>
                <!--Переменные файлов, загруженных по HTTP-->
                $_FILES
                <?php print("<pre>" . print_r($_FILES, true) . "</pre>"); ?>
                <!--Ассоциативный массив (array) значений, переданных скрипту через HTTP Cookies.-->
                <!--Куки (англ. Cookie) — это текстовый файл с данными, который записывается в браузер,
                сервером посещаемого вами сайта. Этими данными являются:
                * информация о логине и пароле;
                * индивидуальные настройки и предпочтения пользователя;
                * статистика посещений и т.д.-->
                $_COOKIE
                <?php print("<pre>" . print_r($_COOKIE, true) . "</pre>"); ?>
                <!--Переменные окружения-->
                $_ENV
                <?php print("<pre>" . print_r($_ENV, true) . "</pre>"); ?>
                <!--Ссылки на все переменные глобальной области видимости-->
                $GLOBALS
                <?php print("<pre>" . print_r($GLOBALS, true) . "</pre>"); ?>
            </p>
        </div>
    </div>
</div>
