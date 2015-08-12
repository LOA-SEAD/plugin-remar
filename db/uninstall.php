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
 * Provides code to be executed during the module uninstallation
 *
 * @see uninstall_plugin()
 *
 * @package    mod_remarmoodle
 * @copyright  2015 Rener Baffa da Silva <renerbaffa@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Custom uninstallation procedure
 */
function xmldb_remarmoodle_uninstall() {
    $removeUrl = 'http://myapp.dev:9090/moodle/remove';
    //$domain = 'sead.ufscar';
    $domain = $_SERVER['HTTP_HOST'];
    
    $curl = new curl();
    //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
    $json = $curl->post($removeUrl, array('domain' => $domain));

    $obj = json_decode($json);
    var_dump($obj);
    die();
    
    return true;
}
