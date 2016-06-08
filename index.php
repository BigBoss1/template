<?php

include("classes/html.php");

HTML::header("Главная");
HTML::template("index");
HTML::footer();

HTML::flush();

Session::store_session();

?>