<?php

include("classes/html.php");
include("classes/user.php");
include("classes/helpers.php");

if (get_or_post("act") == "logout")
{
    $user->fill_unauth();
    $user->set_session();
    header("Location: index.php");
}

if ($user->is_auth())
    header("Location: index.php");

$login = get_or_post("login");
$pass = get_or_post("pass");

if ($user->authorize($login, $pass))
    header("Location: index.php");

HTML::header("Вход");
HTML::template("login");
HTML::footer();

HTML::flush();

Session::store_session();

?>
