<?php

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
 * Web service local plugin template external functions and service definitions.
 *
 * @package    localwstemplate
 * @copyright  2015 Rener Baffa da Silva <renerbaffa@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// We defined the web service functions to install.
$functions = array(
    'mod_remarmoodle_insert_record' => array(
        'classname'   => 'mod_remarmoodle_external', //class name
        'methodname'  => 'insert_record',
        'classpath'   => 'mod/remarmoodle/externallib.php',
        'description' => 'Atualiza ou adiciona um dado em uma tabela criada.',
        'type'        => 'write',
    ),
    'mod_remarmoodle_create_table' => array (
        'classname'   => 'mod_remarmoodle_external',
        'methodname'  => 'create_table',
        'classpath'   => 'mod/remarmoodle/externallib.php',
        'description' => 'Cria uma nova tabela no BD para um novo game.',
        'type'        => 'write'
    ),
    'mod_remarmoodle_link_remar_user' => array (
        'classname'   => 'mod_remarmoodle_external',
        'methodname'  => 'link_remar_user',
        'classpath'   => 'mod/remarmoodle/externallib.php',
        'description' => 'Vincula um usuário do remar com um usuário no moodle.',
        'type'        => 'write'
    ),
    'mod_remarmoodle_token_verifier' => array (
        'classname'   => 'mod_remarmoodle_external',
        'methodname'  => 'token_verifier',
        'classpath'   => 'mod/remarmoodle/externallib.php',
        'description' => 'Retorna o usuário com base no token recebido.',
        'type'        => 'write'
    )
);
// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
    'remarmoodle_service' => array(
        'functions' => array ('mod_remarmoodle_insert_record', 'mod_remarmoodle_create_table', 'mod_remarmoodle_link_remar_user', 'mod_remarmoodle_token_verifier'),
        'restrictedusers' => 0,
        'enabled'=> 1
    )/*,
    'remarmoodle_service' => array(
        'functions' => array ('mod_remarmoodle_create_table'),
        'restrictedusers' => 0,
        'enabled'=> 1
    ),
    'remarmoodle_service' => array (
        'functions' => array ('mod_remarmoodle_link_remar_user'),
        'restictedusers' => 0,
        'enabled' => 1
    )*/
);
