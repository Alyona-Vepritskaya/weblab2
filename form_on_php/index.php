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

function submitForm($psw1, $psw2, $login, $email, $error)
{
    if (!(isIncorrect($psw1, 0) && isIncorrect($psw2, 0) &&
        isIncorrect($login, 0) && emailIsValid($email))) {
        $error = 'Запони форму правильно!!!';

        return $error;
    } elseif ($psw2 != $psw1) {
        $error = 'Пароли не совпадают!!!';
        return $error;
    } else {
        // $error = '';
        return $error;
    }

}

include '../general/header.php';
include 'main.php';
include '../general/footer.php';

