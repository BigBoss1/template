<?php

include("classes/html.php");
include("classes/user.php");
include("classes/helpers.php");

$login = get_or_post("login");
$pass = get_or_post("pass");

User::check_auth($login, $pass);

HTML::header("Вход");
HTML::template("login");
HTML::footer();

HTML::flush();

?>
