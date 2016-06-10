<?php

require_once("classes/session.php");
require_once("classes/db.php");

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

    function update_profile($login, $passwd, $name, $email)
    {
        global $db;

        if ($db->update_profile($this->profile['id'], $login, $passwd, $name, $email))
        {
            $this->profile['login'] = $login;
            $this->profile['name'] = $name;
            $this->profile['email'] = $email;
            $this->set_session();
            return true;
        }
        return false;
    }

    function create_profile($login, $passwd, $name, $email, $reg_date)
    {
        global $db;

        if ($db->create_profile($login, $passwd, $name, $email, $reg_date))
        {
            $this->authenticated = true;
            $this->profile['login'] = $login;
            $this->profile['name'] = $name;
            $this->profile['email'] = $email;
            $this->profile['reg_date'] = $reg_date;
            $this->set_session();
            return true;
        }
        return false;
    }

    function is_auth()
    {
        return $this->authenticated;
    }

    function is_admin()
    {
        return $this->profile['is_admin'] == 't';
    }

    function get_profile()
    {
        return $this->profile;
    }
}

$user = new User();

?>

