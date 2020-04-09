<?php
include "../inc/connect-inc.php";
include "../classes/MyDB.php";
include "classes/ProductModel.php";
include_once "../inc/filter_input_.php";

//TODO - check session
function get_image()
{
    $path = __DIR__ . '/img/';
    //echo $path;
    $submit = filter_input_('input_submit', '');
    if (!empty($submit) && (!empty($_FILES['file']['tmp_name']))) {
        $loaded_file = $_FILES['file'];
        move_uploaded_file($loaded_file['tmp_name'], trim($path . $loaded_file['name']));
        return $loaded_file['name'];
    }
    return '';
}

get_image();
$mysqli = MyDB::get_db_instance();
$action = filter_input_("action", "");
$viewMode = "";
$model = new ProductModel($mysqli);
$sections = $model->getSections();
switch ($action) {
    /*   case "edit":
           $id = filter_input_("id", 0);
           $viewMode = "edit";
           $info = $model->getProduct($id);
           break;*/
    case "delete":
        $id = filter_input_("id", 0);
        $model->deleteProduct($id);
        break;
    /*    case "update_product":
            //TODO
            $id = filter_input_("id", 0);
            $name = filter_input_("name", "");
            $url = filter_input_("url", "");
            $content = filter_input_("content", "");
            /*$model->updateProduct($id, $name, $content, $url);
            break;*/
    case "add_main_info":
        $name = filter_input_("name", "");
        $country = filter_input_("country", "");
        $price = filter_input_("price", "");
        $year = filter_input_("year", "");
        $s_num = filter_input_("s_num", "");
        $id_section = filter_input_("select", "");
        $img_name = get_image();
        $model->addProduct($name, $country, $price, $year, $img_name, $s_num, $id_section);
        $id = $model->getProductBySNum($s_num);
        $viewMode = "add_extra_info";
        break;
    case "add_extra_info":
        $id = filter_input_("id", "");
        $name = filter_input_("param_name", "");
        $value = filter_input_("param_value", "");
        $sort = filter_input_("param_sort", "");
        $model->addParam($id, $name, $value,$sort);
        $viewMode = "add_extra_info";
        break;
}

if ($viewMode == "") {
    $list = $model->getALLProducts();
}
$mysqli->close();
include "inc/header.php";
if ($viewMode == "edit") { ?>
    <div class="form-inside">
    </div>
<?php } elseif ($viewMode == "add_extra_info") { ?>
    <div class="form-inside">
        <form class="f1" action="products.php?action=add_extra_info&id=<?= $id ?>" method="post">
            Param name
            <input required class="fadeIn second" type="text" name="param_name" value="">
            Param value
            <input name="param_value" required class="fadeIn second" type="text" value="">
            Serial number when display information (number)
            <input name="param_sort" required class="fadeIn second" type="text" value="">
            <input type="submit" class="buy-item" value="Update">
            <a href="products.php" class="buy-item2">Back to tables</a>
        </form>
    </div>
<?php } else { ?>
    <table id="customers">
        <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Serial number</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
        <?php foreach ($list as $key => $value) { ?>
            <tr>
                <td> <?= $value['id'] ?></td>
                <td> <?= $value['name'] ?></td>
                <td> <?= $value['s_num'] ?> </td>
                <td><a href="products.php?action=edit&id=<?= $value['id'] ?>" class="buy-item2">Edit</a></td>
                <td><a href="products.php?action=delete&id=<?= $value['id'] ?>" class="buy-item2">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
    <div class="form-inside">
        <form class="f1" action="products.php?action=add_main_info" method="post" enctype="multipart/form-data">
            Name
            <input required class="fadeIn second" type="text" name="name" value="">
            Serial number
            <input name="s_num" required class="fadeIn second" type="text" value="">
            Price:
            <input name="price" required class="fadeIn second" type="text" value="">
            Production date
            <input name="year" required class="fadeIn second" type="text" value="">
            Production country
            <input name="country" required class="fadeIn second" type="text" value="">
            <select name="select">
                <?php foreach ($sections as $key => $value) { ?>
                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                <?php } ?>
            </select>
            Image
            <input name="file" required class="fadeIn second" type="file">
            <input type="submit" class="buy-item" value="Add product" name="input_submit">
        </form>
    </div>
    <?php
}
include "inc/footer.php";