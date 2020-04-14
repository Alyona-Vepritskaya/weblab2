<?php
///////////////////////////////////////////////////////////////////////
// Global initialization
include 'init.php';

///////////////////////////////////////////////////////////////////////
// Global function definition
function get_image()
{
    $path = __DIR__ . '/img/';
    $submit = filter_input_('input_submit', '');
    if (!empty($submit) && (!empty($_FILES['file']['tmp_name']))) {
        $loaded_file = $_FILES['file'];
        move_uploaded_file($loaded_file['tmp_name'], trim($path . $loaded_file['name']));
        return $loaded_file['name'];
    }
    return '';
}

///////////////////////////////////////////////////////////////////////
// Check is user have access to this page
if ($u->checkUserAuth() == 0) 
{
    header(SITE_HOST.'cms/index.php');
    exit();
}

/// !!!!!!! Зачем оно тут вызывалось? функция же внутри switch вызывается! get_image(); //to load img on server

///////////////////////////////////////////////////////////////////////
// Global variables
$action = filter_input_("action", "");
$viewMode = '';
$error_message = null;

$name = filter_input_("name", "");
$country = filter_input_("country", "");
$price = filter_input_("price", "");
$year = filter_input_("year", "");
$s_num = filter_input_("s_num", "");
$id_section = filter_input_("select", "");

///////////////////////////////////////////////////////////////////////
// Get data
$model = new ProductModel($mysqli);
$sections = $model->getSections();


switch ($action) {
    case "edit":
        $id = filter_input_("id", 0);
        if ($id != 0) {
            $viewMode = "edit";
            $info = $model->getProduct($id);
        } else
            $error_message = "Can not edit product, incorrect id";
        break;
		
    case "delete":
        $id = filter_input_("id", 0);
        ($id != 0) ?
            $model->deleteProduct($id) :
            $error_message = "Can not delete product, incorrect id";
        break;
		
    case "delete_param":
        $id_p = filter_input_("id_p", 0);
        $id = filter_input_("id", 0);
		
        $viewMode = "edit";
        if ($id_p != 0) {
            $model->deleteParam($id_p);
        } else
            $error_message = "Can not delete param, incorrect id";
        $info = $model->getProduct($id);
        break;
		
    case "update_product":
        $id = filter_input_("id", 0);
		
        $img_name = get_image();
        $info = $model->getProduct($id);
        ($id != 0 && !empty($name) && !empty($country) && !empty($price) && !empty($year) && !empty($s_num)) ?
            $model->updateProduct($id, $name, $country, $price, $year, $img_name, $s_num) :
            $error_message = "Can not update product, incorrect input data";
        break;
		
    case "add_main_info":		
        $img_name = get_image();
        if (!empty($name) && !empty($country) && !empty($price) && !empty($year) && !empty($s_num) && !empty($img_name)) {
            $model->addProduct($name, $country, $price, $year, $img_name, $s_num, $id_section);
            $id = $model->getProductBySNum($s_num);
        } else {
            $error_message = "Can not add product, incorrect input data";			
		}
        break;
		
    case "add_extra_info":
        $id = filter_input_("id", 0);
        $name = filter_input_("param_name", "");
        $value = filter_input_("param_value", "");
        $sort = filter_input_("param_sort", "");
		
        $viewMode = "edit";
        (!empty($name) && !empty($value) && !empty($sort)) ?
            $model->addParam($id, $name, $value, $sort) :
            $error_message = "Can not add product, incorrect input data";
        $info = $model->getProduct($id);
        break;
}

//////////////////////////////////////////////////////////////
// 
if ($viewMode == "") {
    $list = $model->getALLProducts();
}

///////////////////////////////////////// MAKE PAGE LAYOUT ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////
//
include "inc/header.php";
//
//////////////////////////////////////////////////////////////

if ($viewMode == "edit") 
{ 
?>
    <div class="form-inside">
        <div class="m-auto">
            <a href="products.php" class="buy-item2">Back to tables</a>
            <h4><?= $error_message ?></h4>
        </div>
        <form class="f1" action="products.php?" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update_product">
            <input type="hidden" name="id" value="<?= $id ?>">
            Name
            <input required class="fadeIn second" type="text" name="name" value="<?= $info['name'] ?>">
            Serial number
            <input name="s_num" required class="fadeIn second" type="text" value="<?= $info['s_num'] ?>">
            Price:
            <input name="price" required class="fadeIn second" type="text" value="<?= $info['price'] ?>">
            Production date
            <input name="year" required class="fadeIn second" type="text" value="<?= $info['year'] ?>">
            Production country
            <input name="country" required class="fadeIn second" type="text" value="<?= $info['country'] ?>">
            New Image
            <input name="file" class="fadeIn second" type="file">
            <input type="submit" class="buy-item" value="Update" name="input_submit">
        </form>
        <div class="m-auto">
            <?php foreach ($info['param'] as $key => $value) { ?>
                <?= $value['name'] . " : " . $value['value'] ?>
                <div class="m-auto">
                    <a href="products.php?action=delete_param&id_p=<?= $value['id'] ?>&id=<?= $id ?>" class="buy-item2">Delete</a>
                </div>
            <?php } ?>
        </div>
        <div class="form-inside">
            <div class="m-auto"><h4><?= $error_message ?></h4></div>
            <form class="f1" action="products.php" method="post">
                <input type="hidden" name="action" value="add_extra_info">
                <input type="hidden" name="id" value="<?= $id ?>">
                Param name
                <input required class="fadeIn second" type="text" name="param_name" value="">
                Param value
                <input name="param_value" required class="fadeIn second" type="text" value="">
                Serial number when display information (number)
                <input name="param_sort" required class="fadeIn second" type="text" value="">
                <input type="submit" class="buy-item" value="Add param">
            </form>
        </div>
    </div>
<?php 
} 
else 
{ 
?>
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
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <div class="form-inside">
        <!--Add form-->
        <form class="f1" action="products.php?action=add_main_info" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add_main_info">
            Name
            <input required class="fadeIn second" type="text" name="name" value="<?=$name;?>">
            Serial number
            <input name="s_num" required class="fadeIn second" type="text" value="<?=$s_num;?>">
            Price:
            <input name="price" required class="fadeIn second" type="text" value="<?=$price;?>">
            Production date
            <input name="year" required class="fadeIn second" type="text" value="<?=$year;?>">
            Production country
            <input name="country" required class="fadeIn second" type="text" value="">
            <select name="select">
                <?php foreach ($sections as $key => $value) { ?>
                    <option value="<?= $value['id'] ?>"<?=( $id_section == $value['id'] ? " selected" : "" );?>><?= $value['name'] ?></option>
                <?php } ?>
            </select>
            Image
            <input name="file" required class="fadeIn second" type="file">
            <input type="submit" class="buy-item" value="Add product" name="input_submit">
        </form>
    </div>
<?php
}

///////////////////////////////////////////////////
//
include "inc/footer.php";

$mysqli->close();	// Я бы это делал тут, так как футер тоже может обращаться к базе для формирования каких то элементов
//