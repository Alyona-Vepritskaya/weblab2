<?php

$info = $this->info;
$id = $this->id;
$error_message = $this->error_message;

?>

<div class="form-inside">
    <div class="m-auto">
        <a href="index.php?controller=ProductsController" class="buy-item2">Back to tables</a>
        <h4><?= $error_message ?></h4>
    </div>
    <form class="f1" action="index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="controller" value="ProductsController">
        <input type="hidden" name="action" value="update_product">
        <input type="hidden" name="id" value="<?= $id ?>">
        Name
        <input required class="fadeIn second" type="text" name="name" value="<?= $info['name'] ?>">
        Serial number
        <input name="s_num" required class="fadeIn second" type="text" value="<?= $info['s_num'] ?>">
        Price:
        <input name="price" required class="fadeIn second" type="text" value="<?= $info['price'] ?>">
        Production date
        <input name="year" required class="fadeIn second" type="text" value="<?= $info['year'] ?>">
        Production country
        <input name="country" required class="fadeIn second" type="text" value="<?= $info['country'] ?>">
        New Image
        <input name="file" class="fadeIn second" type="file">
        <input type="submit" class="buy-item" value="Update" name="input_submit">
    </form>
