<?php
include 'init.php';


if ($u->checkUserAuth() == 0) {
    header('Location: ' . SITE_HOST . 'cms/index.php');
    exit();
}
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
        if ($id == $u->getUserId()) {
            $error_message = "!!! Can not delete yourself !!!";
        } else {
            ($id != 0) ?
                $model->deleteUser($id) :
                $error_message = "Can not delete user, incorrect id";
        }
        break;
    case "update":
        $id = filter_input_("id", 0);
        $login = filter_input_("login", "");
        $name = filter_input_("name", "");
        $password = filter_input_("password", "");
        $password2 = filter_input_("password2", "");
        if ($id != 0 && !empty($login) && !empty($password) && !empty($name) && ($password2 == $password)) {
            $model->updateUser($id, $login, $password, $name);
            $name = "";
            $login = "";
        } else {
            $info['id'] = $id;
            $info['login'] = $login;
            $info['name'] = $name;
            $viewMode = "edit";
            $error_message = "Can not update user, incorrect input data";
        }
        break;
    case "add":
        $login = filter_input_("login", "");
        $name = filter_input_("name", "");
        $password = filter_input_("password", "");
        $password2 = filter_input_("password2", "");
        if (!empty($login) && !empty($password) && !empty($name) && ($password2 == $password)) {
            $model->addUser($login, $password, $name);
            $name = "";
            $login = "";
        } else
            $error_message = "Can not add user, incorrect input data";
}
if ($viewMode == "")
    $list = $model->getUsers();
$mysqli->close();
include "inc/header.php";
if ($viewMode == "edit") { ?>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <form class="f1" action="users.php" method="post">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $info['id'] ?>">
            Name
            <input required type="text" class="fadeIn second" name="name" placeholder="" value="<?= $info['name'] ?>">
            Login
            <input required class="fadeIn second" type="text" name="login" value="<?= $info['login'] ?>">
            Password
            <input required name="password" class="fadeIn second" type="password" value="">
            <input required name="password2" class="fadeIn second" type="password" value="">
            <input type="submit" class="buy-item" value="Update">
        </form>
    </div>
<?php } else { ?>
    <table id="customers">
        <tr>
            <td>Id</td>
            <td>Login</td>
            <td>Name</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
        <?php foreach ($list as $key => $value) { ?>
            <tr>
                <td> <?= $value['id'] ?></td>
                <td> <?= $value['login'] ?></td>
                <td> <?= $value['name'] ?></td>
                <td><a href="users.php?action=edit&id=<?= $value['id'] ?>" class="buy-item2">Edit</a></td>
                <td><a href="users.php?action=delete&id=<?= $value['id'] ?>" class="buy-item2">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <form class="f1" action="users.php" method="post">
            <input type="hidden" name="action" value="add">
            Name
            <input value="<?=$name?>" required type="text" class="fadeIn second" name="name" placeholder="">
            Login
            <input value="<?=$login?>" required type="text" class="fadeIn second" name="login" placeholder="">
            Password
            <input required type="password" class="fadeIn second" name="password" placeholder="">
            <input required type="password" class="fadeIn second" name="password2" placeholder="">
            <input type="submit" class="buy-item" value="Add User">
        </form>
    </div>
    <?php
}
include "inc/footer.php";