<?php

require_once("classes/init.php");

$res = null;
$values = array("login" => "", "name" => "", "email" => "");
if (get_or_post("act") == "registrate")
{
    $res = $user->create_profile(get_or_post("login"), get_or_post("passwd"),
        get_or_post("name"), get_or_post("email"), date("Y-m-d"));

    foreach ($values as $k => $v)
        $values[$k] = get_or_post($k, "");
}

HTML::header("Регистрация");

switch ($res)
{
    case -1:
        HTML::template("unique_error");
        break;
    case -2:
        HTML::template("not_null_error");
        break;
    case null:
        break;
    default:
        header("Location: profile.php");
        Session::store_session();
        exit(0);
}

HTML::template("registration", $values);
HTML::footer();

HTML::flush();

Session::store_session();

?>