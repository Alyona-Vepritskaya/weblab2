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
//get products
function get_products($section_id)
{
    global $p_model, $prod;
    $prod = $p_model->get_products($section_id);
    /*print_r($prod);*/
}

if (isset($_GET['section'])) {
    $section_id = $_GET['section'];
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
        }
        foreach ($prod as $key => $value) { ?>
            <div class="product">
                <div class="item-name"><?=$value['name']?></div>
                <img src="<?=$path.$value['img']?>" alt="img">
                <div class="description">
                    <div>Serial number: <?=$value['s_num']?></div>
                    <div>Price: <?=$value['prise']?></div>
                    <div>Production date: <?=$value['year']?></div>
                    <div>Production country: <?=$value['country']?></div>
                    <div class="details">
                        <input name="More"  class="buy-item more" type="submit" value="More">
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
    </div>



