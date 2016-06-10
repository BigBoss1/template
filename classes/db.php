<?php

class DB
{
    private $conn = null;

    function __construct($conn_string = "")
    {
        if ($conn_string == "")
            return;

        if (($this->conn = pg_connect($conn_string)) === false)
            die("Не удалось подключиться к СУБД.");

    }

    function __destruct()
    {
        if ($this->conn !== null && $this->conn !== false)
            pg_close($this->conn);
    }

    function one_row($resource)
    {
        if ($resource === false)
            die(pg_last_error($this->conn));
        $res = pg_fetch_assoc($resource);
        return ($res === false) ? null : $res;
    }

    function all_rows($resource)
    {
        if ($resource === false)
            die(pg_last_error($resource));
        $res = [];
        while (($row = pg_fetch_assoc($resource)) !== false)
            $res[] = $row;
        return $res;
    }

    function check_auth($login, $passwd)
    {
        $resource = pg_query_params($this->conn, "SELECT id, login, name, email, is_admin, reg_date, last_login
            FROM users WHERE login=$1 AND passwd=$2 AND NOT disabled", array($login, md5($passwd)));
        return $this->one_row($resource);
    }

    function update_profile($id, $login, $passwd, $name, $email)
    {
        if ($passwd)
            return pg_query_params($this->conn,
                "UPDATE users SET login=$2, passwd=$3, name=$4, email=$5 WHERE id=$1",
                array($id, $login, md5($passwd), $name, $email));
        else
            return pg_query_params($this->conn,
                "UPDATE users SET login=$2, name=$3, email=$4 WHERE id=$1",
                array($id, $login, $name, $email));
    }

    function create_profile($login, $passwd, $name, $email, $reg_date)
    {
        return pg_query_params($this->conn,
            "INSERT INTO users (login, passwd, name, email, reg_date) VALUES($1, $2, $3, $4, $5)",
            array($login, md5($passwd), $name, $email, $reg_date));
    }
}

$db = new DB("dbname=mult user=mult");

?>