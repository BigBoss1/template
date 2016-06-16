<h1>Список пользователей</h1>
<table cellpadding="5px" cellspacing='2px'>
    <tr>
        <th>Имя</th>
        <th>Логин</th>
        <th>E-mail</th>
        <th>Забанен</th>
    </tr>
    <?php for($i = 0; $i < count($args); $i++) { ?>
    <tr>
        <td><?php echo "<a href='profile.php?id=" . $args[$i]['id'] . "'>" . $args[$i]['name'] . "</a>"; ?></td>
        <td><?php echo $args[$i]['login']; ?></td>
        <td><?php echo $args[$i]['email']; ?></td>
        <td><?php echo ($args[$i]['disabled'] == 't') ? "Да" : "Нет"; ?></td>
        <td><?php echo "<a href='profile.php?id=" . $args[$i]['id'] . "&view=edit'>Редактировать</a>"; ?></td>
    </tr>
    <?php } ?>
</table>