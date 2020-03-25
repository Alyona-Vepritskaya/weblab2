<?php
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
$name = filter_input_("name",'');
$full_name = 'http://k503labs.ukrdomen.com/535a/Veprytskaya/resize_img/'.$name;
/*echo $full_name;*/
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Web_lab</title>
</head>
<body>
<img src="<?=$full_name?>" alt="img">
</body>
</html>
