<?php

require_once("classes/html.php");
require_once("classes/user.php");
require_once("classes/menu.php");
require_once("classes/helpers.php");

if (!$user->is_auth())
    header("Location: index.php");

$profile = $user->get_profile();

if (get_or_post("act") == "edit")
{
    $params = array(
        "id" => $profile['id'],
        "login" => get_or_post("login", $profile['login']),
        "passwd" => get_or_post("passwd", $profile['passwd']),
        "name" => get_or_post("name", $profile['name']),
        "email" => get_or_post("email", $profile['email'])
    );

    $user->update_profile($params);
}

HTML::header($profile['name']);

if (get_or_post("view") == "edit")
    HTML::template("edit_profile", $profile);
else
    HTML::template("profile", $profile);

HTML::footer();

HTML::flush();

Session::store_session();

?>