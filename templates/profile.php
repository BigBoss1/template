<?php

require_once("classes/helpers.php");

?>
<h1>Добро пожаловать, <?php echo $args['name']; ?>!</h1>
<table border="1px" cellpadding="5px">
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
<p><a href="profile.php?<?php if (!$profile['is_owner']) echo "id=" . $args['id'] . "&"; ?>view=edit">Редактировать</a></p>