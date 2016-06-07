<?php

include("classes/html.php");
include("classes/user.php");

HTML::header("Главная");
HTML::template("index");
HTML::footer();

HTML::flush();

?>