<?php

class User
{
	static public $authorized = false;
	static public function get_from_session()
	{
		$data = Session::get("user");
		list(User::$authorized) = $data;
	}

	static public function set_to_session()
	{
		Session::set("user", array('authorized' => User::$authorized));
	}
}

?>

