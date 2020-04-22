<?php

$name = $this->name;
$content = $this->content;
$url = $this->url;

?>

<div class="form-inside">
    <form class="f1" action="index.php" method="post">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="controller" value="NewsController">
        Article name
        <input required type="text" class="fadeIn second" name="name" placeholder="" value="<?=$name?>">
        Content
        <textarea required name="content" class="edit"><?=$content?></textarea>
        Url
        <input required type="text" class="fadeIn second" name="url" placeholder="" value="<?=$url?>">
        <input type="submit" class="buy-item" value="Add Article">
    </form>
</div>
