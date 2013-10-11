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



    $string['pluginname']                   = 'UNC Id Federation Login Block';

    $string['block_title']                  = 'UNC Id Federation';
    $string['text_link_label']              = 'Click to Login';
    $string['visiting_label']               = 'Visitors from other campuses<br />select your Id provider:';

    $string['cfglbl_show_image_link']       = 'Show Image Link';
    $string['cfgdes_show_image_link']       = 'Display the image link.';
    $string['cfglbl_show_text_link']        = 'Show Text Link';
    $string['cfgdes_show_text_link']        = 'Display the text link.';
    $string['cfglbl_show_forgot_link']      = 'Show Forgot Link';
    $string['cfgdes_show_forgot_link']      = 'Display the password reset link.';
    $string['cfglbl_show_idp_list']         = 'Show IdP list';
    $string['cfgdes_show_idp_list']         = 'Display a dropdown-list of Shibboleth IdPs (configured in the Shibboleth auth plugin) from which the user can select.';
    $string['cfglbl_hide_block_header']     = 'Hide block header';
    $string['cfgdes_hide_block_header']     = 'Hide the block header (title) when displayed.';

    $string['shibbuncif:addinstance']       = 'Add UNC Id Federation block';
