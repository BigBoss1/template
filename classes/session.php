<?php

class Session
{
	static $cookie_name = "SPR2016";
	static $session_dir = "sessions/";
	static $data = array();
	static $session_started = false;
	static $uid;

	static public function start_session()
	{
		if (isset($_COOKIE[Session::$cookie_name]))
			Session::restore_session(Session::$cookie_name);
		else
		{
			$uid = md5(microtime(true));
			setcookie(Session::$cookie_name, $uid);
		}
	}

	static public function store_session()
	{
		if (file_put_contents(Session::$session_dir . Session::$uid, serialize(Session::$data)) === false)
			die("Couldn't save session data.");
	}

	static public function restore_session()
	{
		Session::$data = unserialize(file_get_contents(Session::$session_dir . Session::$uid))
	}

	static public function set($name, $value)
	{
		Session::$data[$name] = $value;
	}

	static public function get($name)
	{
		if (!isset(Session::$data[$name]))
			return null;
		return Session::$data[$name];
	}
}

?>