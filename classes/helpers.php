<?php

function get_or_post($name, $value = null)
{
	if (isset($_GET[$name]) && $_GET[$name] != "")
		return $_GET[$name];
	if (isset($_POST[$name]) && $_POST[$name] != "")
		return $_POST[$name];
	return $value;
}

?>