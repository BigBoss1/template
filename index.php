<?php

include("classes/html.php");
include("classes/session.php");

Session::start_session();

HTML::header("Главная");
HTML::template("index");
HTML::footer();

HTML::flush();

Session::store_session();

?>