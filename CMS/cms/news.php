<?php
include "../inc/connect-inc.php";
include "../classes/MyDB.php";
include "classes/UserModel.php";


$mysqli = MyDB::get_db_instance();

$action = getVar("action", ""); //?

$viewMode = "";

$a_Model = new ArticlesModel($mysqli);

switch ($action) {
    case "edit":
        $id = getVar("aid", 0); // get id
        $viewMode = "edit";
        $info = $a_Model->getArticle($id);
        break;
    case "del":
        $id = getVar("aid", 0);
        $a_Model->deleteArticle($id);
        break;
    case "update":
        $id = getVar("aid", 0);
        $name = getVar("a_name", "");
        $author = getVar("a_author", "");
        $content = getVar("a_content", "");
        $a_Model->updateArticle($id, $name, $author, $content);
        break;
    case "add":
        $viewMode = "add";
}

if ($viewMode == "")
    $a_list = $a_Model->getArticles();


include "inc/header.php";

if ($viewMode == "edit") {
    // Тут показать интерфейс с формой редктирования пользователя
} else {
    // $a_list
    // Тут показать интерфейс с таблицой всех articles, где в таблицу напротив каждого пользователя есть две кнопочки - Редактироваи и Удалить
    // Плюс под таблицей можно сделать форму создания нового пользователя
    if ($viewMode == "add") {
        //поакзать форму для добавления
    }
}

include "inc/footer.php";


