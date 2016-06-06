<?php

function get_or_post($key, $value = "")
{
	if (isset($_GET[$key]))
		return $_GET[$key];
	if (isset($_POST[$key]))
		return $_POST[$key];
	return $value;
}

?>