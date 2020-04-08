<?php
include_once "classes/MyDB.php";
include_once 'inc/connect-inc.php';
include "cms/classes/ArticlesModel.php";

$mysqli = MyDB::get_db_instance();
$model = new ArticlesModel($mysqli);
$articles = $model->getArticles();
include '../general/header.php';
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
            <?php foreach ($articles as $key => $value) { ?>
                <div class="article">
                    <h3><?= $value['name'] ?></h3>
                    <a href="<?= $value['url'] ?>">source</a>
                    <p><?= $value['content'] ?></p>
                    <div class="published-date"><?= $value['published_date'] ?></div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php include "../general/footer.php";