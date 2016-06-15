<?php

require_once("classes/init.php");

if (!$user->is_auth())
    header("Location: index.php");

$profile = $user->get_profile();
$is_owner = !(get_or_post("id") && $user->has_rights("users_upd"));
//Shows what profile is going to be updated (owner's profile or profile of another user)

if (!$is_owner && get_or_post("id") == $profile['id'])
    $is_owner = !$is_owner;

if (!$is_owner)
    $profile = $db->get_users(get_or_post("id"));

$profile['is_owner'] = $is_owner;

$res = null;
if (get_or_post("act") == "edit")
{
    $res = $user->update_profile(
        ($profile['is_owner']) ? $profile['id'] : get_or_post("id"),
        get_or_post("login"),
        get_or_post("passwd"),
        get_or_post("name"),
        get_or_post("email"));
}

HTML::header($profile['name']);

switch ($res)
{
    case -1:
        HTML::template("unique_error");
        break;
    case -2:
        HTML::template("not_null_error");
        break;
    case $profile['id']:
        header("Location: profile.php");
        Session::store_session();
        exit(0);
}

if (get_or_post("view") == "edit")
    HTML::template("edit_profile", $profile);
else
    HTML::template("profile", $profile);

HTML::footer();

HTML::flush();

Session::store_session();

?>