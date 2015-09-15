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
 * Provides code to be executed during the module installation
 *
 * This file replaces the legacy STATEMENTS section in db/install.xml,
 * lib.php/modulename_install() post installation hook and partially defaults.php.
 *
 * @package    mod_remarmoodle
 * @copyright  2015 Rener Baffa da Silva <renerbaffa@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Post installation procedure
 *
 * @see upgrade_plugins_modules()
 */

function xmldb_remarmoodle_install() {

	$serverurl = 'http://remar.dc.ufscar.br:8080/moodle/save';
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $serverurl);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array('domain' => $_SERVER['HTTP_HOST'], 'name' => 'Moodle do REMAR'));

	$resp = curl_exec($ch);

	curl_close($ch);
}

/**
 * Post installation recovery procedure
 *
 * @see upgrade_plugins_modules()
 */
function xmldb_remarmoodle_install_recovery() {
}
