<?php
include "../inc/connect-inc.php";
include "../classes/MyDB.php";
include "classes/ArticlesModel.php";
include "../inc/filter_input_.php";
include "classes/UserSessions.php";

$u = new UserSessions();
if ($u->checkUserAuth() != 0) {
    $mysqli = MyDB::get_db_instance();
    $action = filter_input_("action", "");
    $viewMode = "";
    $model = new ArticlesModel($mysqli);
    $error_message = null;
    switch ($action) {
        case "edit":
            $id = filter_input_("id", 0);
            if ($id != 0) {
                $viewMode = "edit";
                $info = $model->getArticle($id);
            } else
                $error_message = "Can not edit article, incorrect id";
            break;
        case "delete":
            $id = filter_input_("id", 0);
            ($id != 0) ?
                $model->deleteArticle($id) :
                $error_message = "Can not delete article, incorrect id";
            break;
        case "update":
            $id = filter_input_("id", 0);
            $name = filter_input_("name", "");
            $url = filter_input_("url", "");
            $content = filter_input_("content", "");
            ($id != 0 && !empty($name) && !empty($content)) ?
                $model->updateArticle($id, $name, $content, $url) :
                $error_message = "Can not update article, incorrect input data";
            break;
        case "add":
            $name = filter_input_("name", "");
            $url = filter_input_("url", "");
            $content = filter_input_("content", "");
            (!empty($name) && !empty($content)) ?
                $model->addArticle($name, $content, $url) :
                $error_message = "Can not add article, incorrect input data";
    }
    if ($viewMode == "")
        $list = $model->getArticles();
    $mysqli->close();
} else {
    header('Location: http://k503labs.ukrdomen.com/535a/Veprytskaya/CMS/cms/index.php');
}
include "inc/header.php";
if ($viewMode == "edit") { ?>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <form class="f1" action="news.php?action=update&id=<?= $info['id'] ?>" method="post">
            Title
            <input required class="fadeIn second" type="text" name="name" value="<?= $info['name'] ?>">
            Content
            <textarea required name="content" class="edit"><?= $info['content'] ?></textarea>
            Url
            <input name="url" required class="fadeIn second" type="text" value="<?= $info['url'] ?>">
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
                <td><a href="news.php?action=edit&id=<?= $value['id'] ?>" class="buy-item2">Edit</a></td>
                <td><a href="news.php?action=delete&id=<?= $value['id'] ?>" class="buy-item2">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <form class="f1" action="news.php?action=add" method="post">
            <input type="hidden" name="hidden_input" value="add_article">
            Article name
            <input required type="text" class="fadeIn second" name="name" placeholder="">
            Content
            <textarea required name="content" class="edit"></textarea>
            Url
            <input required type="text" class="fadeIn second" name="url" placeholder="">
            <input type="submit" class="buy-item" value="Add Article">
        </form>
    </div>
    <?php
}
include "inc/footer.php";