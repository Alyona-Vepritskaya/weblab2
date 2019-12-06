<?php
function filter_input_($name, $default)
{
    $result = $default;
    if (isset($_POST[$name])) {
        $result = $_POST[$name];
    }
    if (isset($_SERVER[$name])) {
        $result = $_SERVER[$name];
    }
    if (isset($_GET[$name])) {
        $result = $_GET[$name];
    }
    return $result;
}


$dirs = array();
$file_size = array();
$file_type = array();
$file_date = array();
$dir = filter_input_("DOCUMENT_ROOT", '');
if (is_dir($dir)) {
    if ($d = opendir($dir)) {
        while (($file = readdir($d)) !== false) {
            $dirs[] = $file;
        }
        closedir($d);
    }
}
foreach ($dirs as $key => $value) {
    $file_size[] = filesize("../" . $value);
    $file_type[] = filetype("../" . $value);
    $file_date[] = date("F d Y H:i:s.", filectime("../" . $value));
}


include "../general/header.php"; ?>
    <div class="right-col">
    <div class="news-info">
        <a href="">
            <div class="news">
                Navigator
            </div>
        </a>
        <div class="date">
            30 февраля 1313
        </div>
    </div>
    <div class="text-content  clearfix">
        <div id="registered">
            Файловый навигатор
            <table>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($dirs as $key => $value) {
                    echo "<tr><td>$value</td>";
                    echo "<td>$file_type[$key]</td>";
                    echo "<td>$file_size[$key]</td>";
                    echo "<td>$file_date[$key]</td></tr>";

                } ?>
            </table>
        </div>
    </div>
    <input type="file" class="submit" name="add_file">
<?php
include "../general/footer.php";
