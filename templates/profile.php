<?php

require_once("classes/helpers.php");

?>
<?php if ($args['is_owner']) { ?>
<h1>Добро пожаловать, <?php echo $args['name']; ?>!</h1>
<?php } else { ?>
<h1><?php echo $args['name']; ?></h1>
<?php } ?>
<table cellpadding="5px">
    <tr>
        <td>Логин:</td>
        <td><?php echo $args['login']; ?></td>
    </tr>
    <tr>
        <td>E-mail</td>
        <td><?php echo $args['email']; ?></td>
    </tr>
    <tr>
        <td>Дата регистрации:</td>
        <td><?php echo $args['reg_date']; ?></td>
    </tr>
    <tr>
        <td>Последний вход:</td>
        <td><?php echo $args['last_login']; ?></td>
    </tr>
</table>
<p><a href="profile.php?<?php if (!$args['is_owner']) echo "id=" . $args['id'] . "&"; ?>view=edit">Редактировать</a></p>