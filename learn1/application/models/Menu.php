<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Model
{
    public function get_menu_by_role($role_id)
    {
        $query = "SELECT user_menu.id, menu
                  FROM user_menu
                  JOIN user_accessmenu 
                  ON user_menu.id = user_accessmenu.menu_id
                  WHERE user_accessmenu.role_id = ?
                  ORDER BY user_accessmenu.menu_id ASC";
        return $this->db->query($query, [$role_id])->result_array();
    }

    public function get_submenu_by_menu($menu_id)
    {
        $query = "SELECT * 
                  FROM user_submenu
                  JOIN user_menu 
                  ON user_submenu.menu_id = user_menu.id
                  WHERE user_submenu.menu_id = ?";
        return $this->db->query($query, [$menu_id])->result_array();
    }
}
