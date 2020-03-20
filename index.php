<html>
<head>
    <meta charset="utf-8">
    <title>Лабораторные 535а</title>
    <style>
        body
        {
            font-family: Arial;
        }
    </style>
</head>
Для тех, кому лень писать путь к своей папке руками :)
<ul>
<?php
$url = 'http://k503labs.ukrdomen.com/535a/';
$folders = array_diff(scandir(__DIR__), array('..', '.'));
foreach ($folders as $folder)
{
    if(is_file($folder))
        continue;

    echo "<li><a href=\"$url$folder\">$folder</a></li>";
}
?>
</ul>
</body>
</html>