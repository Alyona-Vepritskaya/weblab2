<?php
include_once 'init.php';

$mysqli = MyDB::get_db_instance();
$model = new UserModel($mysqli);
$users = $model->getUsers();
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
            <h3>User's login</h3>
            <?php foreach ($users as $key => $value) { ?>
                <div class="article">
                    <h3>User -> <?= $value['login'] ?></h3>
                </div>
            <?php } ?>
        </div>
    </div>
<?php include "../general/footer.php";