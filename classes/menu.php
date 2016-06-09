<?php

class Menu
{
    static $menu = array(
        array("name" => "Главная", "url" => "index.php", "allowed" => true),
        array("name" => "Профиль", "url" => "profile.php", "allowed" => false),
        array("name" => "Список пользователей", "url" => "users_list.php", "allowed" => false),
        array("name" => "Вход", "url" => "login.php", "allowed" => true),
        array("name" => "Выход", "url" => "login.php?act=logout", "allowed" => false)
    );

    static function get_menu_html()
    {
        global $user;

        if ($user->is_auth())
        {
            Menu::$menu[1]['allowed'] = true;
            if ($user->is_admin())
                Menu::$menu[2]['allowed'] = true;
            Menu::$menu[3]['allowed'] = false;
            Menu::$menu[4]['allowed'] = true;
        }
        $html = "<p>";

        foreach (Menu::$menu as $m)
        {
            if ($m['allowed'])
                $html .= "<a href='" . $m['url'] . "'>" . $m['name'] . "</a> | ";
        }

        $html = substr($html, 0, strlen($html) - 3) . "</p>\n";

        return $html;
    }
}

?>