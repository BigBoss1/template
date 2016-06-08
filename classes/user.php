<?php

include("classes/session.php");
include("classes/db.php");

class User
{
	private $authenticated;
    private $profile;
    static $session_key = "user_info";

    function __construct()
    {
        $this->get_from_session();
    }

    function __destruct()
    {
        $this->set_session();
    }

	function get_from_session()
	{
		if (!Session::$started)
        {
            $this->fill_unauth();
            return false;
        }

        if (($sess_data = Session::get(User::$session_key)) === null)
        {
            $this->fill_unauth();
            return false;
        }

        $this->authenticated = $sess_data['authenticated'];
        $this->profile = $sess_data['profile'];

        return $this->authenticated;
	}

	function set_session()
	{
		Session::set(User::$session_key,
            array('authenticated' => $this->authenticated, 'profile' => $this->profile));
	}

    function fill_unauth()
    {
        $this->authenticated = false;
        $this->profile = array();
    }

    function authorize($login, $password)
    {
        global $db;

        if (($this->profile = $db->check_auth($login, $password)) !== null)
        {
            $this->authenticated = true;
            $this->set_session();
            return true;
        }

        $this->fill_unauth();
        return false;
    }

    function is_auth()
    {
        return $this->authenticated;
    }
}

$user = new User();

?>

