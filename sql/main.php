<?php
include_once 'MyDB.php';
include_once 'connect-inc.php';
include_once 'create_tables.php';
include_once 'xml_parse.php';
include_once 'fill_tables.php';
include_once 'ProductModel.php';

// ------------ connect to db ------------
$mysqli = MyDB::get_db_instance();
// ------------- create struct -----------
create_struct($mysqli);
// ------------- insert data from xml -----------
//get data
parseData();
//add to DB
insert_data($products, $mysqli);
// ------------- select data -----------
$p_model = new ProductModel($mysqli);
$sections = $p_model->get_sections();
$all_products = null;
$one_product = null;
$current_section = null;
$current_product = null;
$q = filter_input_("section", '');
$id = filter_input_("id", '');
//get products
function get_products($section_id)
{
    global $p_model, $all_products;
    $all_products = $p_model->get_products($section_id);
}

function get_product($prod_id)
{
    global $p_model, $one_product;
    $one_product = $p_model->get_product_params($prod_id);
}

function filter_input_($name, $default)
{
    $result = $default;
    if (isset($_POST[$name])) {
        $result = $_POST[$name];
    }
    if (isset($_GET[$name])) {
        $result = $_GET[$name];
    }
    return $result;
}

if (!empty($q)) {
    $current_section = $q;
    get_products($current_section);
}
if (!empty($id)) {
    $current_product = $id;
    get_product($current_product);
}
?>
<div class="right-col">
    <div class="news-info">
        <a href="">
            <div class="news">
                SQL
            </div>
        </a>
        <div class="date">
            30 февраля 1313
        </div>
    </div>
    <div class="text-content  clearfix">
        <div class="products">
            <?php
            if (is_null($one_product)) {
                foreach ($sections as $key => $value) { ?>
                    <a href="index.php?section=<?= $key ?>" class="buy-item"><?= $value ?></a>
                    <?php
                    if ($current_section == $key) {
                        foreach ($all_products as $k => $v) { ?>
                            <div class="product">
                                <div class="item-name"><?= $v['name'] ?></div>
                                <img src="<?= $path . $v['img'] ?>" alt="img">
                                <div class="description">
                                    <div>Serial number: <?= $v['s_num'] ?></div>
                                    <div>Price: <?= $v['price'] ?></div>
                                    <div>Production date: <?= $v['year'] ?></div>
                                    <div>Production country: <?= $v['country'] ?></div>
                                    <div class="details">
                                        <a href="index.php?id=<?= $v['s_num'] ?>" class="buy-item more">More</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            } else {
                ?>
                <div class="product">
                    <div class="item-name"><?= $one_product['name'] ?></div>
                    <img src="<?= $path . $one_product['img'] ?>" alt="img">
                    <div class="description">
                        <div>Serial number: <?= $one_product['s_num'] ?></div>
                        <div>Price: <?= $one_product['price'] ?></div>
                        <div>Production date: <?= $one_product['year'] ?></div>
                        <div>Production country: <?= $one_product['country'] ?></div>
                        <?php foreach ($one_product['param'] as $key => $value) { ?>
                            <div><?= $value['name'] . " : " . $value['value'] ?></div>
                        <?php } ?>
                        <div class="details">
                            <input type="button" class="buy-item more" value="Add to card">
                        </div>
                    </div>
                </div>
                <form action="" name="review" method="post" class="form">
                    <div class="block">
                        Input name:
                        <input id="name" type="text" required">
                    </div>
                    <div class="block">
                        Input email:
                        <input id="name" type="email" required>
                    </div>
                    <div class="block">
                    <textarea required class="area" name="comment">
                    </textarea>
                    </div>
                    <div class="block">
                        <input type="submit" class="buy-item more" value="Submit">
                </form>
                <?php
            } ?>
        </div>
    </div>



