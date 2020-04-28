<?php

$list = $this->list;
$error_message = $this->error_message;

?>

<table id="customers">
    <tr>
        <td>Id</td>
        <td>Name</td>
        <td>Email</td>
        <td>Id product</td>
        <td>Delete</td>
    </tr>
    <?php foreach ($list as $key => $value) { ?>
        <tr>
            <td> <?= $value['id'] ?></td>
            <td> <?= $value['name'] ?></td>
            <td> <?= $value['email'] ?></td>
            <td> <?= $value['id_product'] ?></td>
            <td><a href="index.php?controller=CommentsController&action=delete&id=<?= $value['id'] ?>" class="buy-item2">Delete</a></td>
        </tr>
    <?php } ?>
</table>

<?php if (!empty($error_message)) { ?>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
<?php } ?>
