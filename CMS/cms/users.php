<?php
include "../inc/connect-inc.php";
include "../classes/MyDB.php";
include "classes/UserModel.php";
include_once "../inc/filter_input_.php";
include "classes/UserSessions.php";

$u = new UserSessions();
if ($u->checkUserAuth() != 0) {
    $mysqli = MyDB::get_db_instance();
    $action = filter_input_("action", "");
    $viewMode = "";
    $model = new UserModel($mysqli);
    $error_message = null;
    switch ($action) {
        case "edit":
            $id = filter_input_("id", 0);
            if ($id != 0) {
                $viewMode = "edit";
                $info = $model->getUser($id);
            } else
                $error_message = "Can not edit user, incorrect id";
            break;
        case "delete":
            $id = filter_input_("id", 0);
            ($id != 0) ?
                $model->deleteUser($id) :
                $error_message = "Can not delete user, incorrect id";
            break;
        case "update":
            $id = filter_input_("id", 0);
            $login = filter_input_("login", "");
            $password = filter_input_("password", "");
            ($id != 0 && !empty($login) && !empty($password)) ?
                $model->updateUser($id, $login, $password) :
                $error_message = "Can not update user, incorrect input data";
            break;
        case "add":
            $login = filter_input_("login", "");
            $password = filter_input_("password", "");
            (!empty($login) && !empty($password)) ?
                $model->addUser($login, $password) :
                $error_message = "Can not add user, incorrect input data";
    }
    if ($viewMode == "")
        $list = $model->getUsers();
    $mysqli->close();
}else{
    header('Location: http://k503labs.ukrdomen.com/535a/Veprytskaya/CMS/cms/index.php');
}
include "inc/header.php";
if ($viewMode == "edit") { ?>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <form class="f1" action="users.php?action=update&id=<?= $info['id'] ?>" method="post">
            Login
            <input required class="fadeIn second" type="text" name="login" value="<?= $info['login'] ?>">
            Password
            <input required name="password" class="fadeIn second" type="password" value="">
            <input type="submit" class="buy-item" value="Update">
        </form>
    </div>
<?php } else { ?>
    <table id="customers">
        <tr>
            <td>Id</td>
            <td>Login</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
        <?php foreach ($list as $key => $value) { ?>
            <tr>
                <td> <?= $value['id'] ?></td>
                <td> <?= $value['login'] ?></td>
                <td><a href="users.php?action=edit&id=<?= $value['id'] ?>" class="buy-item2">Edit</a></td>
                <td><a href="users.php?action=delete&id=<?= $value['id'] ?>" class="buy-item2">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <form class="f1" action="users.php?action=add" method="post">
            <input type="hidden" name="hidden_input" value="add_user">
            Login
            <input required type="text" class="fadeIn second" name="login" placeholder="">
            Password
            <input required type="password" class="fadeIn second" name="password" placeholder="">
            <input type="submit" class="buy-item" value="Add User">
        </form>
    </div>
    <?php
}
include "inc/footer.php";