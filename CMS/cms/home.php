<?php
include 'init.php';
if ($u->checkUserAuth() == 0) {
    header('Location: '.SITE_HOST.'cms/index.php');
    exit();
}
include_once "inc/header.php";?>
<main class="content">
    <h1>You are at home</h1>
</main>
<?php
include_once "inc/footer.php";