<?php

require_once("classes/html.php");
require_once("classes/user.php");
require_once("classes/menu.php");
require_once("classes/helpers.php");

if (!$user->is_auth() && !$user->is_admin())
    header("Location: index.php");

$users = $db->get_users();

HTML::header("Список пользователей");
HTML::template("users_list", $users);
HTML::footer();

HTML::flush();

Session::store_session();

?>