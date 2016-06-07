<?php

include("classes/session.php");

class User
{
	static public $authorized = false;
	static public function get_from_session()
	{
		$data = Session::get("user");
		User::$authorized = $data['authorized'];
		print(User::$authorized);
	}

	static public function check_auth($login, $pass)
	{
		$temp = explode("\n", file_get_contents(".htauth"));

		foreach ($temp as $t)
			if ($t == $login . ":" . $pass)
			{
				User::$authorized = true;
				User::set_to_session();
				Session::store_session();
				return 0;
			}

		return 0;
	}

	static public function set_to_session()
	{
		Session::set("user", array('authorized' => User::$authorized));
	}
}

User::get_from_session();

?>

