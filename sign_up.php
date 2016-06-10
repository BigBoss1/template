<?php

require_once("classes/html.php");
require_once("classes/user.php");
require_once("classes/menu.php");
require_once("classes/helpers.php");

if (get_or_post("act") == "sign_up")
{
    $params = array(
        "login" => get_or_post("login"),
        "passwd" => get_or_post("passwd"),
        "name" => get_or_post("name"),
        "email" => get_or_post("email"),
        "reg_date" => date("Y-m-d")
    );

    if ($user->create_profile($params))
        header("Location: profile.php");
}

HTML::header("Регистрация");
HTML::template("sign_up");
HTML::footer();

HTML::flush();

Session::store_session();

?>