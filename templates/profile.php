<?php

require_once("classes/helpers.php");

?>
<?php if ($args['is_owner']) { ?>
<h1>Добро пожаловать, <?php echo $args['name']; ?>!</h1>
<?php } else { ?>
<h1><?php echo $args['name']; ?></h1>
<?php } ?>
<table cellpadding="5px" cellspacing='2px'>
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
        <td>
            <script>
                document.write(get_date("<?php echo $args['reg_date']; ?>"));
            </script>
        </td>
    </tr>
    <tr>
        <td>Последний вход:</td>
        <td>
            <script>
                document.write(get_datetime("<?php echo $args['last_login']; ?>"));
            </script>
        </td>
    </tr>
</table>
<p><a href="profile.php?<?php if (!$args['is_owner']) echo "id=" . $args['id'] . "&"; ?>view=edit">Редактировать</a></p>