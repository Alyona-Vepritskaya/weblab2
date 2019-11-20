<?php
$login = filter_input(INPUT_POST, 'login');
$psw1 = filter_input(INPUT_POST, 'psw1');
$psw2 = filter_input(INPUT_POST, 'psw2');
$email = filter_input(INPUT_POST, 'email');
$error = '';
function isIncorrect($value, $originValue)
{
    return strlen($value) > $originValue;
}

function emailIsValid($email)
{
    return preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+$/", $email);
}

if (!(isIncorrect($psw1, 3) && isIncorrect($psw2, 3) &&
    isIncorrect($login, 0) && emailIsValid($email))) {
    $error = 'Запони форму правильно!!!';
} elseif ($psw2 != $psw1) {
    $error = 'Пароли не совпадают!!!';
} else {
    $error = '';
}
include('index.php');




