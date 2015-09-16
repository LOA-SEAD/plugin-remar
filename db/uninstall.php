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
	/*$serverurl = 'http://remar.dc.ufscar.br:8080/moodle/remove';
		
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $serverurl);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array('domain' => $_SERVER['HTTP_HOST']);

	$resp = curl_exec($ch);

	curl_close($ch);*/

    return true;
}
