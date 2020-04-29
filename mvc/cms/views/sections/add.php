<?php

$name = $this->name;

?>
<div class="form-inside">
    <form class="f1" action="<?= Controller::formatUrl('SectionsController', 'add')?>" method="post">
        <!--<input type="hidden" name="controller" value="SectionsController">
        <input type="hidden" name="action" value="add">-->
        New name
        <input required type="text" class="fadeIn second" name="name" placeholder="" value="<?=$name?>">
        <input type="submit" class="buy-item" value="Add Section">
    </form>
</div>
