<?php

class Menu
{
    static $menu = array(
        array("name" => "Главная", "url" => "index.php", "allowed" => "all"),
        array("name" => "Профиль", "url" => "profile.php", "allowed" => "users"),
        array("name" => "Список пользователей", "url" => "users_list.php", "allowed" => "admins"),
        array("name" => "Вход", "url" => "login.php", "allowed" => "guests"),
        array("name" => "Регистрация", "url" => "registration.php", "allowed" => "guests"),
        array("name" => "Выход", "url" => "login.php?act=logout", "allowed" => "users")
    );

    static function get_menu_html()
    {
        global $user;

        $html = "<p>";

        foreach (Menu::$menu as $m)
        {
            if ($m['allowed'] == "all")
                $html .= "<a href='" . $m['url'] . "'>" . $m['name'] . "</a> | ";
            elseif ($user->is_auth())
            {
                if ($m['allowed'] == "users" || ($user->is_admin() && $m['allowed'] == "admins"))
                    $html .= "<a href='" . $m['url'] . "'>" . $m['name'] . "</a> | ";
            }
            elseif ($m['allowed'] == "guests")
                $html .= "<a href='" . $m['url'] . "'>" . $m['name'] . "</a> | ";
        }

        $html = substr($html, 0, strlen($html) - 3) . "</p>\n";

        return $html;
    }
}

?>