<?php
include "../inc/connect-inc.php";
include "../classes/MyDB.php";
include "classes/UserModel.php";

// соединение с базой и другая инициализация

$action = getVar("action", ""); //?
$viewmode = "";

$userModel = new UserModel();

switch($action)
{
   /* case "edit":
        $uid = getVar("uid", 0);
        $uid0 intval($uid);
		if($uid0 == 0 )
            break;

		$viewmode = "edit";

		$uinfo = $userModel->getUserInfo($uid);
		break;

    case "del":
        $uid = getVar("uid", 0);
        $uid0 intval($uid);
		if($uid0 == 0 )
            break;

		$userModel->removeUser($uid);
		break;

    case "update":
        $uid = getVar("uid", 0);
        $uid0 intval($uid);
		if($uid0 == 0 )
            break;

		$uname = getVar("uname", "");

		$userModel->saveUser($uid, $uname);
		break;

    case "add":
        ....*/
}

if( $viewmode == "" )
    $ulist = $userModel->getList();


include "inc/header.php";

if( $viewmode == "edit" )
{
    // Тут показать интерфейс с формой редктирования пользователя
}
else
{
    // Тут показать интерфейс с таблицой всех пользователей, где в таблицу напротив каждого пользователя есть две кнопочки - Редактироваи и Удалить
    // Плюс под таблицей можно сделать форму создания нового пользователя
}

include "inc/footer.php";


