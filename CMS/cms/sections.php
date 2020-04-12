<?php
include 'init.php';

$u = new UserSessions();
if ($u->checkUserAuth() == 0) {
    header('Location: http://k503labs.ukrdomen.com/535a/Veprytskaya/CMS/cms/index.php');
    exit();
}
$mysqli = MyDB::get_db_instance();
$action = filter_input_("action", "");
$viewMode = "";
$model = new ProductModel($mysqli);
$error_message = null;
switch ($action) {
    case "edit":
        $id = filter_input_("id", 0);
        if ($id != 0) {
            $viewMode = "edit";
            $info = $model->getSection($id);
        } else
            $error_message = "Can not edit section, incorrect id";
        break;
    case "delete":
        $id = filter_input_("id", 0);
        ($id != 0) ?
            $model->deleteSection($id) :
            $error_message = "Can not delete section, incorrect id";
        break;
    case "update":
        $id = filter_input_("id", 0);
        $name = filter_input_("name", "");
        if ($id != 0 && !empty($name)) {
            $model->updateSection($id, $name);
        } else {
            $info['id'] = $id;
            $info['name'] = $name;
            $viewMode = "edit";
            $error_message = "Can not update section, incorrect input data";
        }
        break;
    case "add":
        $name = filter_input_("name", "");
        (!empty($name)) ?
            $model->addSection($name) :
            $error_message = "Can not add section, incorrect input data";
}
if ($viewMode == "")
    $list = $model->getSections();
$mysqli->close();
include "inc/header.php";
if ($viewMode == "edit") { ?>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <form class="f1" action="sections.php" method="post">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $info['id'] ?>">
            New name
            <input required class="fadeIn second" type="text" name="name" value="<?= $info['name'] ?>">
            <input type="submit" class="buy-item" value="Update">
        </form>
    </div>
<?php } else { ?>
    <table id="customers">
        <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
        <?php foreach ($list as $key => $value) { ?>
            <tr>
                <td> <?= $value['id'] ?></td>
                <td> <?= $value['name'] ?></td>
                <td><a href="sections.php?action=edit&id=<?= $value['id'] ?>" class="buy-item2">Edit</a></td>
                <td><a href="sections.php?action=delete&id=<?= $value['id'] ?>" class="buy-item2">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <form class="f1" action="sections.php" method="post">
            <input type="hidden" name="action" value="add">
            New name
            <input required type="text" class="fadeIn second" name="name" placeholder="">
            <input type="submit" class="buy-item" value="Add Section">
        </form>
    </div>
    <?php
}
include "inc/footer.php";