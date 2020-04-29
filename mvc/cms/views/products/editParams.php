<?php

$error_message = $this->error_message;
$id = $this->id;
$info_params = $this->info_params;
$n = $this->n;
$v = $this->v;
$sort = $this->sort;

?>

<div class="m-auto">
    <?php foreach ($info_params['param'] as $key => $value) { ?>
        <?= $value['name'] . " : " . $value['value'] ?>
        <div class="m-auto">
            <a href="index.php?controller=ProductsController&action=delete_param&id_p=<?= $value['id'] ?>&id=<?= $id ?>" class="buy-item2">Delete</a>
        </div>
    <?php } ?>
</div>
<div class="form-inside">

    <?php if (!empty($error_message)) { ?>
        <div class="m-auto"><h4><?= $error_message ?></h4></div>
    <?php } ?>

    <form class="f1" action="<?= Controller::formatUrl('ProductsController', 'add_extra_info',array('id'=>$id))?>" method="post">
        <!--<input type="hidden" name="controller" value="ProductsController">
        <input type="hidden" name="action" value="add_extra_info">
        <input type="hidden" name="id" value="<?/*= $id */?>">-->
        Param name
        <input required class="fadeIn second" type="text" name="param_name" value="<?=$n?>">
        Param value
        <input name="param_value" required class="fadeIn second" type="text" value="<?=$v?>">
        Serial number when display information (number)
        <input name="param_sort" required class="fadeIn second" type="text" value="<?=$sort?>">
        <input type="submit" class="buy-item" value="Add param">
    </form>
</div>
</div>
