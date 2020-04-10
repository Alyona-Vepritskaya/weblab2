<?php
include_once 'init.php';

$current_page = null;
$mysqli = MyDB::get_db_instance();
$model = new PagesModel($mysqli);
$pages = $model->getPages();

$action = filter_input_("page", "");
if (!empty($action)) {
    $current_page = $model->getPageByUrl($action);
}
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
        <div class="articles">
            <ul>
                <?php foreach ($pages as $key => $value) { ?>
                    <li>
                        <a href="pageList.php?page=<?= $value['url'] ?>"><?= $value['url'] ?></a>
                    </li>
                <?php } ?>
            </ul>
            <?php if (!is_null($current_page)) { ?>
                <div class="article">
                    <h3><?= $current_page['name'] ?></h3>
                    <p><?= $current_page['content'] ?></p>
                    <div class="published-date"><?= $current_page['published_date'] ?></div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php include "../general/footer.php";