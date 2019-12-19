<?php
/**
 * @param $size - in bytes
 * @return string - size in b, kb, mb, gb
 */
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
    if (isset($_GET[$name])) {
        $result = $_GET[$name];
    }
    return $result;
}

/**
 * @param $path - directory(if is dir)
 * @return void
 * shares, sorts, gets data about  dirs & files
 */
function openDirectory($path)
{
    global $directories, $files, $dir_date, $file_date, $file_size;
    $inner_dirs = array();
    if (is_dir($path)) {
        if ($d = opendir($path)) {
            while (($file = readdir($d)) !== false) {
                $inner_dirs[] = $file;
                (is_file($path . $file)) ? $files[] = $file : $directories[] = $file;
            }
            closedir($d);
        }
    }
    natcasesort($files);
    natcasesort($directories);
    foreach ($files as $key => $value) {
        $file_date[] = date('Y.m.d _ H:i:s', filectime($path . $value));
        $file_size[] = convertSize(filesize($path . $value));
    }
    foreach ($directories as $key => $value) {
        $dir_date[] = date('Y.m.d _ H:i:s', filectime($path . $value));
    }
}

function loadFile()
{
    $submit = filter_input_('input_submit', '');
    if (!empty($submit)) {
        if (!empty($_FILES['file']['tmp_name'])) {
            $loaded_file = $_FILES['file'];
            $file_hidden = filter_input_('hidden', '');
            !empty($file_hidden) ? $current_path = $file_hidden : $current_path = '';
            move_uploaded_file($loaded_file['tmp_name'], trim($current_path . $loaded_file['name']));
        }
    }
}

function find_path($value)
{
    global $path,$end_of_path;
    if ($value != '..') {
        return substr($path, $end_of_path, strlen($path) - 1) . $value;
    } else {
        $tmp = substr((substr($path, $end_of_path, strlen($path) - 1) . $value), 0, strlen($path) - 1);
        $tmp2 = strrpos($tmp, '\\');
        $final = substr($tmp, 0, $tmp2);
        $tmp3 = strrpos($final, '\\');
        return substr($final, 0, $tmp3);
    }
}

$directories = array();
$files = array();
$file_date = array();
$dir_date = array();
$file_size = array();
$end_of_path  = strrpos(__DIR__, '\\') + 1;
$path = substr(__DIR__, 0, $end_of_path);

if (filter_input_('get_request', 'no_request') != 'no_request') {
    $dir = filter_input_('get_request', '');
    (!(strpos($dir, '..') === false && strpos($dir, '\\\\') === false && strpos($dir, '//') === false)) ?
        $path = substr(__DIR__, 0, strrpos(__DIR__, '\\') + 1) : $path .= ($dir . '\\');
    $path = str_replace('\\\\', '\\', $path);
}
openDirectory($path);
loadFile();
include "../general/header.php"; ?>
    <div class="right-col">
    <div class="news-info">
        <a href="">
            <div class="news">
                Navigator
            </div>
        </a>
        <div class="date">
            30 февраля 666
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
                <?php
                foreach ($directories as $key => $value) {
                    if ($value != '.')
                    {
                        $path_get = find_path($value);
                        echo "<tr><td><a href='index.php?get_request=$path_get'>$value</a></td>";
                        echo "<td>dir</td>";
                        echo "<td>-</td>";
                        echo "<td>$dir_date[$key]</td></tr>";
                    }
                }
                foreach ($files as $key => $value) {
                    echo "<tr><td>$value</td>";
                    echo "<td>file</td>";
                    echo "<td>$file_size[$key]</td>";
                    echo "<td>$file_date[$key]</td></tr>";
                }
                ?>
            </table>
        </div>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <input type="file" class="submit" name="file">
            <input type="hidden" class="submit" name="hidden" value="<?=$path?>">
            <input type="submit" class="submit" name="input_submit" value="Load to current directory">
        </form>
    </div>
<?php
include "../general/footer.php";