<?php

$error_message = $this->error_message;
$info = $this->section;

?>

<?php if (!empty($error_message)) { ?>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
<?php } ?>

<div class="form-inside">
    <form class="f1" action="index.php" method="post">
        <input type="hidden" name="controller" value="SectionsController">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= $info['id'] ?>">
        New name
        <input required class="fadeIn second" type="text" name="name" value="<?= $info['name'] ?>">
        <input type="submit" class="buy-item" value="Update">
    </form>
</div>
