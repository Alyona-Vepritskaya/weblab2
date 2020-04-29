<?php

$name = $this->name;
$s_num = $this->s_num;
$price = $this->price;
$year = $this->year;
$country = $this->country;
$sections = $this->sections;
$id_section = $this->id_section;

?>

<div class="form-inside">
    <!--Add form-->
    <form class="f1" action="<?= Controller::formatUrl('ProductsController', 'add')?>" method="post" enctype="multipart/form-data">
    <!--    <input type="hidden" name="controller" value="ProductsController">
        <input type="hidden" name="action" value="add">-->
        Name
        <input required class="fadeIn second" type="text" name="name" value="<?=$name?>">
        Serial number
        <input name="s_num" required class="fadeIn second" type="text" value="<?=$s_num?>">
        Price:
        <input name="price" required class="fadeIn second" type="text" value="<?=$price?>">
        Production date
        <input name="year" required class="fadeIn second" type="text" value="<?=$year?>">
        Production country
        <input name="country" required class="fadeIn second" type="text" value="<?=$country?>">
        <select name="select">
            <?php foreach ($sections as $key => $value) { ?>
                <option value="<?= $value['id'] ?>"<?=( $id_section == $value['id'] ? " selected" : "" );?>><?= $value['name'] ?></option>
            <?php } ?>
        </select>
        Image
        <input name="file" required class="fadeIn second" type="file">
        <input type="submit" class="buy-item" value="Add product" name="input_submit">
    </form>
</div>
