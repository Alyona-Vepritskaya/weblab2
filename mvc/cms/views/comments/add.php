<?php

$name = $this->name;
$email = $this->email;
$comment = $this->comment;
$id_prod = $this->id_prod;

?>

<div class="form-inside">
    <form class="f1" action="index.php" method="post">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="controller" value="CommentsController">
        Name
        <input required type="text" class="fadeIn second" name="name" placeholder="" value="<?= $name ?>">
        Email
        <input required type="email" class="fadeIn second" name="email" placeholder="" value="<?= $email ?>">
        Comment
        <textarea required class="edit" name="comment"><?= $comment ?></textarea>
        Product ID
        <input required type="text" class="fadeIn second" name="id_prod" placeholder="" value="<?= $id_prod ?>">
        <input type="submit" class="buy-item" value="Add Comment">
    </form>
</div>
