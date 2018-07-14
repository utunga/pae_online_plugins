<?php

if (!defined('ABSPATH')) {
    die('-1');
}

class Quadmenu_Locations {

    public function __construct() {

        $this->_wp_registered_nav_menus();

        add_action('init', array($this, 'locations'), -19);

        add_action('admin_init', array($this, '_wp_registered_nav_menus_fix'));

        add_action('switch_theme', array($this, '_wp_registered_nav_menus_delete'));
    }

    function _wp_registered_nav_menus_fix() {

        global $_wp_registered_nav_menus, $quadmenu_locations;

        if (!is_array($_wp_registered_nav_menus))
            return;

        if ((count($quadmenu_locations) == count($_wp_registered_nav_menus)))
            return;

        update_option('_wp_registered_nav_menus', $_wp_registered_nav_menus);
    }

    function _wp_registered_nav_menus_delete() {

        delete_option('_wp_registered_nav_menus');
    }

    function _wp_registered_nav_menus() {

        global $_wp_registered_nav_menus;

        if (is_array($_wp_registered_nav_menus) && count($_wp_registered_nav_menus))
            return;

        $_wp_registered_nav_menus = array_filter((array) get_option('_wp_registered_nav_menus'));
    }

    public function locations() {

        global $_wp_registered_nav_menus, $quadmenu, $quadmenu_locations;

        $quadmenu_locations = array();

        if (!is_array($_wp_registered_nav_menus))
            return;

        if (!count($_wp_registered_nav_menus))
            return;

        foreach ($_wp_registered_nav_menus as $location => $name) {

            if (!empty($quadmenu[$location . '_editor']))
                $quadmenu_locations[$location] = 'manual';

            if (empty($quadmenu[$location . '_integration']))
                continue;

            $quadmenu_locations[$location] = $name;

            if (empty($quadmenu[$location . '_theme']))
                continue;

            $quadmenu_locations[$location] = $quadmenu[$location . '_theme'];
        }
    }

}

new Quadmenu_Locations();
