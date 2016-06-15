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
        $this->profile = array(
            "rights" => array("profile_upd" => false, "users_upd" => false)
        );
    }

    function authorize($login, $password)
    {
        global $db;

        if (($this->profile = $db->check_auth($login, $password)) !== null)
        {
            $this->authenticated = true;
            $this->profile['rights'] = $db->get_rights($this->profile['id']);
            $this->set_session();
            return true;
        }

        $this->fill_unauth();
        return false;
    }

    function update_profile($id, $login, $passwd, $name, $email)
    {
        global $db;
        $res = $db->update_profile($id, $login, $passwd, $name, $email);

        if ($this->profile['id'] == $res)
        {
            $this->profile['login'] = $login;
            $this->profile['name'] = $name;
            $this->profile['email'] = $email;
            $this->set_session();
        }

        return $res;
    }

    function create_profile($login, $passwd, $name, $email, $reg_date)
    {
        global $db;
        $res = $db->create_profile($login, $passwd, $name, $email, $reg_date);

        if ($res > 0)
        {
            $this->authorize($login, $passwd);
            $this->set_session();
        }

        return $res;
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

    function has_rights($rights)
    {
        return ($this->profile['rights'][$rights] == 't') ? true : false;
    }
}

$user = new User();

?>

