<?php

require_once("classes/init.php");

HTML::header("Главная");
HTML::template("index");
HTML::footer();

HTML::flush();

Session::store_session();

?>