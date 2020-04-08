<?php
include '../general/header.php';
include_once "classes/MyDB.php";
include_once 'inc/connect-inc.php';
include "cms/classes/PagesModel.php";

$mysqli = MyDB::get_db_instance();
$model = new PagesModel($mysqli);
$pages = $model->getPages();

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
        <div class="articles">
            <?php foreach ($pages as $key => $value) { ?>
                    <a href="pageList.php?page=<?= $value['url'] ?>"><?= $value['url'] ?></a>
            <?php } ?>
        </div>
    </div>
<?php
include "../general/footer.php";