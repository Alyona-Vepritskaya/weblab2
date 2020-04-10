<?php
include 'init.php';

$u = new UserSessions();
if ($u->checkUserAuth() == 0) {
    header('Location: http://k503labs.ukrdomen.com/535a/Veprytskaya/CMS/cms/index.php');
    exit();
}
$error_message = null;
$mysqli = MyDB::get_db_instance();
$action = filter_input_("action", "");
$viewMode = "";
$model = new ProductModel($mysqli);
$error_message = null;
switch ($action) {
    case "delete":
        $id = filter_input_("id", 0);
        ($id != 0) ?
            $model->deleteProductReviews($id) :
            $error_message = "Can not delete comment, incorrect id";
        break;
    case "add":
        $id_prod = filter_input_("id_prod", "");
        $email = filter_input_("email", "");
        $name = filter_input_("name", "");
        $comment = filter_input_("comment", "");
        if ($model->getProduct($id_prod) != 0) {
            $model->addProductReviews($email, $id_prod, $name, $comment);
            $id_prod = "";
            $email = "";
            $name = "";
            $comment = "";
        } else
            $error_message = "Can not delete comment, no product with this ID";
}
if ($viewMode == "")
    $list = $model->getProductsReviews();
$mysqli->close();
include "inc/header.php"; ?>
    <table id="customers">
        <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Email</td>
            <td>Id product</td>
            <td>Delete</td>
        </tr>
        <?php foreach ($list as $key => $value) { ?>
            <tr>
                <td> <?= $value['id'] ?></td>
                <td> <?= $value['name'] ?></td>
                <td> <?= $value['email'] ?></td>
                <td> <?= $value['id_product'] ?></td>
                <td><a href="comments.php?action=delete&id=<?= $value['id'] ?>" class="buy-item2">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <form class="f1" action="comments.php?action=add" method="post">
            <input type="hidden" name="action" value="add">
            Name
            <input required type="text" class="fadeIn second" name="name" placeholder="" value="<?= $name ?>">
            Email
            <input required type="email" class="fadeIn second" name="email" placeholder="" value="<?= $email ?>">
            Comment
            <textarea required class="edit" name="comment"><?= $comment ?></textarea>
            Product ID
            <input required type="text" class="fadeIn second" name="id_prod" placeholder="" value="<?= $id_prod ?>">
            <?= $error_message ?>
            <input type="submit" class="buy-item" value="Add Comment">
        </form>
    </div>
<?php
include "inc/footer.php";