<?php

require_once("classes/init.php");

if (!$user->is_auth() && !$user->is_admin())
{
    header("Location: index.php");
    exit(0);
}

$users = $db->get_users();

HTML::header("Список пользователей");
HTML::template("users_list", $users);
HTML::footer();

HTML::flush();

Session::store_session();

?>