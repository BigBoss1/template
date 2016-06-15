<?php

require_once("classes/init.php");

if (get_or_post("act") == "registrate")
{
    if ($user->create_profile(get_or_post("login"), get_or_post("passwd"),
        get_or_post("name"), get_or_post("email"), date("Y-m-d")))
        header("Location: profile.php");
}

HTML::header("Регистрация");
HTML::template("registration");
HTML::footer();

HTML::flush();

Session::store_session();

?>