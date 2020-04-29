<?php

$error_message = $this->error_message;
$list = $this->ulist;

///////////////////////////////////////// MAKE PAGE LAYOUT ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<table id="customers">
    <tr>
        <td>Id</td>
        <td>Login</td>
        <td>Name</td>
        <td>Edit</td>
        <td>Delete</td>
    </tr>
    <?php foreach ($list as $key => $value) { ?>
        <tr>
            <td> <?= $value['id'] ?></td>
            <td> <?= $value['login'] ?></td>
            <td> <?= $value['name'] ?></td>
            <td>
                <a href="<?= Controller::formatUrl('UsersController', 'edit',array('id'=>$value['id']))?>"
                   class="buy-item2">Edit</a>
            </td>
            <td>
                <a href="<?= Controller::formatUrl('UsersController', 'delete',array('id'=>$value['id']))?>"
                   class="buy-item2">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php if (!empty($error_message)) { ?>
    <div class="m-auto"><h4><?= $error_message ?></h4></div>
<?php } ?>
