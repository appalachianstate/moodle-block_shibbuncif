<?php

    // This file is part of Moodle - http://moodle.org/
    //
    // Moodle is free software: you can redistribute it and/or modify
    // it under the terms of the GNU General Public License as published by
    // the Free Software Foundation, either version 3 of the License, or
    // (at your option) any later version.
    //
    // Moodle is distributed in the hope that it will be useful,
    // but WITHOUT ANY WARRANTY; without even the implied warranty of
    // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    // GNU General Public License for more details.
    //
    // You should have received a copy of the GNU General Public License
    // along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

    /**
     *  UNC Id Federation (Shibboleth) authentication plugin
     *
     * @package    block_shibbuncif
     * @author     Fred Woolard
     * @copyright  2013 Appalachian State University
     * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */

    defined('MOODLE_INTERNAL') || die();

    require (dirname(__FILE__) . '/version.php');



    /**
     * shibblogin block settings.php file
     *
     * Used for global (as opposed to block instance) configs.
     */

    if ($ADMIN->fulltree) {

        $field = 'show_image_link';
        $adminSetting = new admin_setting_configcheckbox(
            $field,
            get_string("cfglbl_{$field}", $plugin->component),
            get_string("cfgdes_{$field}", $plugin->component),
            "0");
        $adminSetting->plugin = $plugin->component;
        $settings->add($adminSetting);
        unset($adminSetting);

        $field = 'show_text_link';
        $adminSetting = new admin_setting_configcheckbox(
            $field,
            get_string("cfglbl_{$field}", $plugin->component),
            get_string("cfgdes_{$field}", $plugin->component),
            "1");
        $adminSetting->plugin = $plugin->component;
        $settings->add($adminSetting);
        unset($adminSetting);

        $field = 'show_forgot_link';
        $adminSetting = new admin_setting_configcheckbox(
            $field,
            get_string("cfglbl_{$field}", $plugin->component),
            get_string("cfgdes_{$field}", $plugin->component),
            "1");
        $adminSetting->plugin = $plugin->component;
        $settings->add($adminSetting);
        unset($adminSetting);

        $field = 'show_idp_list';
        $adminSetting = new admin_setting_configcheckbox(
        		$field,
        		get_string("cfglbl_{$field}", $plugin->component),
        		get_string("cfgdes_{$field}", $plugin->component),
        		"0");
        $adminSetting->plugin = $plugin->component;
        $settings->add($adminSetting);
        unset($adminSetting);

        $field = 'hide_block_header';
        $adminSetting = new admin_setting_configcheckbox(
                $field,
                get_string("cfglbl_{$field}", $plugin->component),
                get_string("cfgdes_{$field}", $plugin->component),
                "0");
        $adminSetting->plugin = $plugin->component;
        $settings->add($adminSetting);
        unset($adminSetting);

    }
