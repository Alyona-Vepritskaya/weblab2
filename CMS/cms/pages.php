<?php
include "../inc/connect-inc.php";
include "../classes/MyDB.php";
include "classes/PagesModel.php";
include_once "../inc/filter_input_.php";

//TODO - check session

$mysqli = MyDB::get_db_instance();
$action = filter_input_("action", "");
$viewMode = "";
$model = new PagesModel($mysqli);
switch ($action) {
    case "edit":
        $id = filter_input_("id", 0);
        $viewMode = "edit";
        $info = $model->getPage($id);
        break;
    case "delete":
        $id = filter_input_("id", 0);
        $model->deletePage($id);
        break;
    case "update":
        $id = filter_input_("id", 0);
        $name = filter_input_("name", "");
        $url = filter_input_("url", "");
        $content = filter_input_("content", "");
        $model->updatePage($id, $name, $content, $url);
        break;
    case "add":
        $name = filter_input_("name", "");
        $url = filter_input_("url", "");
        $content = filter_input_("content", "");
        $model->addPage($name, $content, $url);
}

if ($viewMode == "")
    $list = $model->getPages();

include "inc/header.php";
if ($viewMode == "edit") { ?>
    <div class="form-inside">
        <form class="f1" action="pages.php?action=update&id=<?= $info['id'] ?>" method="post">
            Title
            <input required pattern="[^ ]" class="fadeIn second" type="text" name="name" value="<?= $info['name'] ?>">
            Content
            <textarea required name="content" class="edit"><?= $info['content'] ?></textarea>
            Url
            <input required name="url" class="fadeIn second" type="text" value="<?= $info['url'] ?>">
            <input type="submit" class="buy-item" value="Update">
        </form>
    </div>
<?php } else { ?>
    <table id="customers">
        <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Published Date</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
        <?php foreach ($list as $key => $value) { ?>
            <tr>
                <td> <?= $value['id'] ?></td>
                <td> <?= $value['name'] ?></td>
                <td> <?= $value['published_date'] ?> </td>
                <td><a href="pages.php?action=edit&id=<?= $value['id'] ?>" class="buy-item2">Edit</a></td>
                <td><a href="pages.php?action=delete&id=<?= $value['id'] ?>" class="buy-item2">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
    <div class="form-inside">
        <form class="f1" action="pages.php?action=add" method="post">
            <input type="hidden" name="hidden_input" value="add_page">
            Title
            <input required pattern="[^ ]" type="text" class="fadeIn second" name="name" placeholder="">
            Content
            <textarea required name="content" class="edit"></textarea>
            Url
            <input required type="text" class="fadeIn second" name="url" placeholder="">
            <input type="submit" class="buy-item" value="Add Page">
        </form>
    </div>
    <?php
}
include "inc/footer.php";