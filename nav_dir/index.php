<?php

function convertSize($size)
{
    $units = 'B';
    $new_size = $size;
    if ($new_size > 1024) {
        $new_size = $new_size / 1024;
        $units = 'KB';
    }
    if ($new_size > 1024) {
        $new_size = $new_size / 1024;
        $units = 'MB';
    }
    if ($new_size > 1024) {
        $new_size = $new_size / 1024;
        $units = 'GB';
    }
    return round($new_size, 2) . ' ' . $units;
}

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

/**
 * @param $dir - directory(if is dir)
 * @return array - content(files & dirs)
 */
function openDirectory($dir)
{
    $inner_dirs = array();
    if (is_dir($dir)) {
        if ($d = opendir($dir)) {
            while (($file = readdir($d)) !== false) {
                $inner_dirs[] = $file;
            }
            closedir($d);
        }
    } else {
        //TODO open & read file
    }
    return $inner_dirs;
}

function getFileDirDate($dirs, $path)
{
    $file_date = array();
    foreach ($dirs as $key => $value) {
        $file_date[$key] = date("Y.m.d _ H:i:s", filectime($path . $value));
    }
    return $file_date;
}

function getFileSize($dirs, $path)
{
    $file_size = array();
    foreach ($dirs as $key => $value) {
        if (is_file($path . $value))
            $file_size[$key] = convertSize(filesize($path . $value));
        else
            $file_size[$key] = ' - ';
    }
    return $file_size;
}

function getFileDirType($dirs, $path)
{
    $file_type = array();
    foreach ($dirs as $key => $value) {
        $file_type[$key] = filetype($path . $value);
    }
    return $file_type;
}

$dirs = array();
$file_size = array();
$file_type = array();
$file_date = array();

if (filter_input_("get_request", 'no_request') == 'no_request') {
    $dir = filter_input_("DOCUMENT_ROOT", '');
    $path = '../';
} else {
    $dir = filter_input_("get_request", '');
    $path = $dir;
}
$dirs = openDirectory($path);
$file_type = getFileDirType($dirs, $path);
$file_size = getFileSize($dirs, $path);
$file_date = getFileDirDate($dirs, $path);

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
            <table>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($dirs as $key => $value) {
                    $path_get = '../' . $value . '/';
                    echo "<tr><td><a href='index.php?get_request=$path_get'>$value</a></td>";
                    echo "<td>$file_type[$key]</td>";
                    echo "<td>$file_size[$key]</td>";
                    echo "<td>$file_date[$key]</td></tr>";
                } ?>
            </table>
        </div>
        <input type="file" class="submit" name="add_file">
    </div>

<?php
include "../general/footer.php";
/**/ ?><!--
        <script>
            console.log('fuck');
        </script>
--><?php