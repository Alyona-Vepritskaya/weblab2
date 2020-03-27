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
$prod = null;
$current_section = null;
//get products
function get_products($section_id)
{
    global $p_model, $prod;
    $prod = $p_model->get_products($section_id);
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

$q = filter_input_("section", '');
if (!empty($q)) {
    $section_id = $q;
    $current_section = $section_id;
    get_products($section_id);
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
            foreach ($sections as $key => $value) { ?>
                <a href="index.php?section=<?= $key ?>" class="buy-item"><?= $value ?></a>
                <?php
                if ($current_section == $key) {
                    foreach ($prod as $k => $v) { ?>
                        <div class="product">
                            <div class="item-name"><?= $v['name'] ?></div>
                            <img src="<?= $path . $v['img'] ?>" alt="img">
                            <div class="description">
                                <div>Serial number: <?= $v['s_num'] ?></div>
                                <div>Price: <?= $v['prise'] ?></div>
                                <div>Production date: <?= $v['year'] ?></div>
                                <div>Production country: <?= $v['country'] ?></div>
                                <div class="details">
                                    <input name="More" class="buy-item more" type="submit" value="More">
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>



