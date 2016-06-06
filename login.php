<?php

include("classes/html.php");
include("classes/session.php");
include("classes/helpers.php");

$login = get_or_post("login");
$pass = get_or_post("pass");

$data = explode("\n", file_get_contents(".htauth"));

foreach ($data as $t)
    if ($t == $login . ":" . $pass)
    {
        //
    }

HTML::header("Вход");
HTML::template("login");
HTML::footer();

HTML::flush();

?>
