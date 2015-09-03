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

    require_once (dirname(__FILE__) . '/../../auth/shibbuncif/auth.php');



    class block_shibbuncif extends block_base
    {

        /**
         * Constants
         */
        const   BLOCK_NAME                      = 'block_shibbuncif';
        const   BLOCK_PATH                      = 'blocks/shibbuncif';
        const   BLOCK_VERSION                   = '2013052000';

        const   BUTTON_IMAGE_FILENAME           = 'pix/button.png';


        /**
         * Helper var to provide filesystem location of this block's code.
         *
         * @var string
         * @access private
         */
        private $blockDir;

        /**
         * Helper var to provide url to this block's resources
         *
         * @var string
         * @access private
         */
        private $blockUrl;

        /**
         * Where to go to reset a password
         *
         * @var string
         * @access private
         */
        private $forgotUrl;

        /**
         * Configuration info for this block (global not instance).
         *
         * @var stdClass
         * @access private
         */
        private $blockConfigs;



        /**
         * Called by the parent's constructor
         *
         * @uses $CFG
         */
        function init()
        {
            global $CFG;



            $this->title        = get_string('block_title', self::BLOCK_NAME);
            $this->version      = self::BLOCK_VERSION;

            $this->blockConfigs = get_config(self::BLOCK_NAME);


            $this->blockDir     = "{$CFG->dirroot}/" . self::BLOCK_PATH . "/";
            $this->blockUrl     = "{$CFG->wwwroot}/" . self::BLOCK_PATH . "/";

            $this->forgotUrl    = empty($CFG->forgottenpasswordurl)
                                ? ''
                                : $CFG->forgottenpasswordurl;

        }



        /**
         * Just use it at the site level
         */
        function applicable_formats()
        {
            return array('site' => true);
        }



        /**
         * Override
         * @see block_base::get_content()
         * Return the HTML to display for this block. Payload is in stdClass object with
         * a 'text' property and a 'footer' property, both of which are type string.
         *
         * @return stdClass
         * @uses   $CFG
         */
        function get_content ()
        {
            global $CFG;


            if ($this->content !== null) {
                return $this->content;
            }

            $this->content         = new stdClass();
            $this->content->footer =
            $this->content->text   = '';

            // Determine if the login button and/or text
            // link need to be displayed.
            if (!isloggedin() || isguestuser()) {
              
              $this->content->text = html_writer::tag('h2', "Log in");
                // If they want a button link...
                if (!empty($this->blockConfigs->show_image_link)) {
                    $imgtag = html_writer::link(auth_plugin_shibbuncif::get_protected_resource_url(), get_string('text_link_label', self::BLOCK_NAME), array('class' => 'btn btn-large btn-asu', 'data-ajax' => 'false'));
                    $this->content->text .= html_writer::tag('p', $imgtag);
                }

                // If they want a text link...
                if (!empty($this->blockConfigs->show_text_link)) {
                    $lnktag = html_writer::link(auth_plugin_shibbuncif::get_protected_resource_url(), get_string('text_link_label', self::BLOCK_NAME), array('data-ajax' => 'false'));
                    $this->content->text .= html_writer::tag('p', $lnktag , array('class' => 'text_link'));
                }
                
                // Password reset link
                if (!empty($this->blockConfigs->show_forgot_link) && !empty($this->forgotUrl)) {
                    $lnktag = html_writer::link($this->forgotUrl, get_string('forgotaccount'));
                    $this->content->text .= html_writer::tag('p', $lnktag , array('class' => 'text_link_forgot'));
                }

                // If they want an IdP list...
                $idp_list = auth_plugin_shibbuncif::get_wayf_idp_list();
                if (!empty($this->blockConfigs->show_idp_list) && !empty($idp_list)) {
                    
                    // Determine the path for the common domain cookie
                    list($host, $path) = auth_plugin_shibbuncif::split_wwwroot();
                    $this->content->text .=
                    "<div class=\"idpform\">\n"
                 .  "<form name=\"shibbuncif\" method=\"post\" action=\"" . auth_plugin_shibbuncif::get_wayf_url() . "\">\n"
                 .  "<input name=\"sessinit\" type=\"hidden\" value=\"" . auth_plugin_shibbuncif::get_login_url() . "?target=" . auth_plugin_shibbuncif::get_protected_resource_url() . "&amp;entityID=\" >\n"
                 .  "<input name=\"cookiepath\" type=\"hidden\" value=\"{$path}\">"
                 .  "<p>" . get_string('visiting_label', self::BLOCK_NAME) . "</p>\n"
                 .  "<select id=\"idp\" name=\"idp\">\n"
                 .  "<option value=\"-\">" . get_string("auth_shib_wayf_select_prompt", auth_plugin_shibbuncif::PLUGIN_NAME) . "</option>\n";
                    $preferred_idp = auth_plugin_shibbuncif::get_common_domain_cookie();
                    $selected_set  = false;
                    foreach($idp_list as $idp_entity_id => $idp_values_array) {
                        $idp_label = array_shift($idp_values_array);
                        $selected_attr = '';
                        if (!$selected_set && $idp_entity_id === $preferred_idp) {
                            $selected_attr = ' selected';
                            $selected_set = true;
                        }
                        $this->content->text .= "<option value=\"{$idp_entity_id}\"{$selected_attr}>{$idp_label}</option>\n";
                    }
                    $this->content->text .= "</select>\n"
                                         .  "<input type=\"submit\" value=\"Submit\">\n"
                                         .  "</form>\n"
                                         .  "</div>\n";
                }

                $admtag = html_writer::link(auth_plugin_shibbuncif::get_wayf_url(), "Manual log in");
                $this->content->footer .= html_writer::tag('p', $admtag);

                $this->page->requires->js_init_call('M.block_shibbuncif.init', null, true);

            } // if (!isloggedin() or isguestuser())

            // And we're done
            return $this->content;

        } // get_content



        /**
         * Override
         * @see block_base::has_config()
         */
        function has_config()
        {
            return true;
        }



        /**
         * Override
         * @see block_base::config_save()
         */
        function config_save($data)
        {

            // Have some check boxes to validate
            if (!isset($data->show_image_link)) {
                $data->show_image_link = '0';
            }
            if (!isset($data->show_text_link)) {
                $data->show_text_link = '1';
            }
            if (!isset($data->show_forgot_link)) {
                $data->show_forgot_link = '1';
            }
            if (!isset($data->show_idp_list)) {
                $data->show_idp_list = '0';
            }
            if (!isset($data->show_block_header)) {
                $data->hide_block_header = '0';
            }
            // Save it in the mdl_config_plugins table
            foreach ($data as $name => $value) {
                set_config($name, $value, self::BLOCK_NAME);
            }

            return true;

        } // config_save



        /**
         * Override
         * @see block_base::hide_header()
         */
        function hide_header()
        {
            return (boolean)$this->blockConfigs->hide_block_header;
        }


    } // class
