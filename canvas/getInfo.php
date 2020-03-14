<?php
// Generating a random number in a
// Specified range.
$randomNumber = rand(1,10);
$arr = array($randomNumber);
for ($i = 0; $i < $randomNumber; $i++) {
    $arr[$i] = rand(0,400);
}
$myJSON = json_encode($arr);
echo $myJSON;
