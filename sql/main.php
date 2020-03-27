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
$p_model = new ProductModel();
$sections = $p_model->get_sections($mysqli);
include '../general/header.php'; ?>
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
        <?php
        foreach ($sections as $key => $value) { ?>
            <input type="button" class="buy-item" value="<?=$value?>">
        <?php
        }
        ?>
    </div>
<?php
include '../general/footer.php';

