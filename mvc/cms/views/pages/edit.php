<?php

$error_message = $this->error_message;
$info = $this->page;

?>

<div class="m-auto"><h4><?= $error_message ?></h4></div>
<div class="form-inside">
    <form class="f1" action="index.php" method="post">
        <input type="hidden" name="controller" value="PagesController">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= $info['id'] ?>">
        Name
        <input required class="fadeIn second" type="text" name="name" value="<?= $info['name'] ?>">
        Content
        <textarea required name="content" class="edit"><?= $info['content'] ?></textarea>
        Url
        <input name="url" required class="fadeIn second" type="text" value="<?= $info['url'] ?>">
        <input type="submit" class="buy-item" value="Update">
    </form>
</div>
