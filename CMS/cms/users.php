<?php
include "../inc/connect-inc.php";
include "../classes/MyDB.php";
include "classes/UserModel.php";

$mysqli = MyDB::get_db_instance();

$action = getVar("action", ""); //?

$viewMode = "";

$u_Model = new UserModel($mysqli);

switch ($action) {
    case "edit":
        $id = getVar("uid", 0); //?
        $id0 = intval($id);
        if ($id0 == 0)
            break;
        $viewMode = "edit";
        $info = $u_Model->getUser($id);
        break;
    case "del":
        $id = getVar("uid", 0);
        $id0 = intval($id);
        if ($id0 == 0)
            break;
        $u_Model->deleteUser($id);
        break;
    case "update":
        $id = getVar("uid", 0);
        $id0 = intval($id);
        if ($id0 == 0)
            break;
        $u_name = getVar("u_name", "");
        $u_password = getVar("u_name", "");
        $u_Model->updateUser($id, $u_name, $u_password);
        break;
    case "add":
        $viewMode = "add";
}

if ($viewMode == "")
    $u_list = $u_Model->getUsers();


include "inc/header.php";

if ($viewMode == "edit") {
    // Тут показать интерфейс с формой редктирования пользователя
} else {
    // $u_list
    // Тут показать интерфейс с таблицой всех пользователей, где в таблицу напротив каждого пользователя есть две кнопочки - Редактироваи и Удалить
    // Плюс под таблицей можно сделать форму создания нового пользователя
    if($viewMode == "add"){
        //поакзать форму для добавления
    }
}

include "inc/footer.php";


