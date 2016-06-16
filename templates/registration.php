<h1>Регистрация</h1>
<form method="post">
    <input type="hidden" name="act" value="registrate">
    <table cellpadding="5px" cellspacing='2px'>
        <tr>
            <td>Имя:</td>
            <td><input type="text" name="name" value="<?php echo $args['name']; ?>"></td>
        </tr>
        <tr>
            <td>Логин:</td>
            <td><input type="text" name="login" value="<?php echo $args['login']; ?>"></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td><input type="password" name="passwd"></td>
        </tr>
        <tr>
            <td>E-mail:</td>
            <td><input type="text" name="email" value="<?php echo $args['email']; ?>"></td>
        </tr>
    </table>
    <p></p><input type="submit" value="Регистрация"></p>
</form>