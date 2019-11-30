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
            <br>
            <table class="server">
                <tr>
                    <td class="vars">$_GET</td>
                    <td></td>
                </tr>
                <?php
                foreach($_GET as $key => $value){
                    echo "<tr><td>$key</td>";
                    echo "<td>$value</td></tr>";

                }?>
                <tr>
                    <td class="vars">$_POST</td>
                    <td></td>
                </tr>
                <tr>
                    <?php
                    foreach($_POST as $key => $value){
                        echo "<tr><td>$key</td>";
                        echo "<td>$value</td></tr>";

                    }?>
                </tr>
                <tr>
                    <td class="vars">$_SERVER</td>
                    <td></td>
                </tr>
                <tr>
                    <?php
                    foreach($_SERVER as $key => $value){
                        echo "<tr><td>$key</td>";
                        echo "<td>$value</td></tr>";
                    }?>
                </tr>
                <tr>
                    <td class="vars">$_COOKIE</td>
                    <td></td>
                </tr>
                <tr>
                    <?php
                    foreach($_COOKIE as $key => $value){
                        echo "<tr><td>$key</td>";
                        echo "<td>$value</td></tr>";
                    }?>
                </tr>
            </table>
        </div>
    </div>
</div>
