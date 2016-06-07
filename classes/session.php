<?php

class Session
{
	static public $cookie_name = "SPR2016";
	static public $session_dir = "sessions/";
	static public $data = array();
	static public $session_started = false;
	static public $uid = "";

	static public function start_session()
	{
        if (isset($_COOKIE[Session::$cookie_name]))
			Session::restore_session();
		else
		{
			Session::$uid = md5(microtime(true));
			setcookie(Session::$cookie_name, Session::$uid);
			Session::store_session();
		}
	}

	static public function store_session()
	{
		if (file_put_contents(Session::$session_dir.Session::$uid, serialize(Session::$data)) === false)
			die("Couldn't save session data.");
	}

	static public function restore_session()
	{
		Session::$uid = $_COOKIE[Session::$cookie_name];
		Session::$data = unserialize(file_get_contents(Session::$session_dir . Session::$uid));
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

Session::start_session();

?>