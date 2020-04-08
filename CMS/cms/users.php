<?php
include "../inc/connect-inc.php";
include "../classes/MyDB.php";
include "classes/UserModel.php";
include_once "../inc/filter_input_.php";

//TODO - check session

$mysqli = MyDB::get_db_instance();
$action = filter_input_("action", "");
$viewMode = "";
$model = new UserModel($mysqli);
switch ($action) {
    case "edit":
        $id = filter_input_("id", 0);
        $viewMode = "edit";
        $info = $model->getUser($id);
        break;
    case "delete":
        $id = filter_input_("id", 0);
        $model->deleteUser($id);
        break;
    case "update":
        $id = filter_input_("id", 0);
        $login = filter_input_("login", "");
        $password = filter_input_("password", "");
        $model->updateUser($id, $login, $password);
        break;
    case "add":
        $login = filter_input_("login", "");
        $password = filter_input_("password", "");
        $model->addUser($login, $password);
}

if ($viewMode == "")
    $list = $model->getUsers();

include "inc/header.php";
if ($viewMode == "edit") { ?>
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