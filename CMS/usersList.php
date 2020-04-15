<?php
///////////////////////////////////////////////////////////////////////
// Global initialization
include_once 'init.php';

///////////////////////////////////////////////////////////////////////
// Global variables
$model = new UserModel($mysqli);
$users = $model->getUsers();

///////////////////////////////////////// MAKE PAGE LAYOUT ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
            <h3>User's data</h3>
            <?php foreach ($users as $key => $value) { ?>
                <div class="article">
                    <h3>User login -> <?= $value['login'] ?></h3>
                    <h3>User name -> <?= $value['name'] ?></h3>
                </div>
            <?php } ?>
        </div>
    </div>
<?php
//////////////////////////////////////////////////////////////////////

include "../general/footer.php";