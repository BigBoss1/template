<?php

require_once("classes/init.php");

if (get_or_post("act") == "logout")
{
    $user->fill_unauth();
    $user->set_session();
    header("Location: index.php");
    Session::store_session();
    exit(0);
}

if ($user->is_auth())
    header("Location: profile.php");

$login = get_or_post("login");
$pass = get_or_post("pass");

HTML::header("Вход");

if ($user->authorize($login, $pass))
{
    header("Location: profile.php");
    Session::store_session();
    exit(0);
}
else if ($login != null || $pass != null)
    HTML::template("login_error");

HTML::template("login");
HTML::footer();

HTML::flush();

Session::store_session();

?>
