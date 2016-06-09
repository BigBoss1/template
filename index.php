<?php

require_once("classes/html.php");
require_once("classes/user.php");
require_once("classes/menu.php");

HTML::header("Главная");
HTML::template("index");
HTML::footer();

HTML::flush();

Session::store_session();

?>