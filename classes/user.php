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
        //Load user data from session
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
        //Set user data to session
		Session::set(User::$session_key,
            array('authenticated' => $this->authenticated, 'profile' => $this->profile));
	}

    function fill_unauth()
    {
        //Data for unauthenticated users
        $this->authenticated = false;
        $this->profile = array();
    }

    function authorize($login, $password)
    {
        //Authorize users
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

    function update_profile($params)
    {
        global $db;
        $db->update_profile($params);
    }

    function is_auth()
    {
        //Check users's authorization
        return $this->authenticated;
    }

    function is_admin()
    {
        return $this->profile['is_admin'] == 't';
    }

    function get_profile()
    {
        //Get user's profile
        return $this->profile;
    }
}

$user = new User();

?>

