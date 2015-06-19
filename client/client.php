<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$token = '679243871a5bca89ba09a0c87f0ed60a';
$domainname = 'localhost/moodle';

/// FUNCTION NAME
$functionname = 'mod_remarmoodle_create_table';
$restformat = 'json';

/// PARAMETERS
$structure = array (
    'field1' => array (
        'name' => 'id',
        'type' => 'INTEGER',
        'length' => '10',
        'notnull' => true,
        'sequence' => true,
        'unsigned' => true,
        'primary' => true
        //'comment' => 'Id'
    ),
    'field2' => array (
        'name' => 'userid',
        'type' => 'INTEGER',
        'length' => '10',
        'notnull' => true,
        'sequence' => false,
        'unsigned' => true
        //'comment' => 'User id'
    ),
    'field3' => array (
        'name' => 'instance_id',
        'type' => 'INTEGER',
        'length' => '10',
        'notnull' => true,
        'sequence' => false,
        'unsigned' => true
        //'comment' => 'Game instance'
    ),
    'field4' => array (
        'name' => 'cm',
        'type' => 'INTEGER',
        'length' => '10',
        'notnull' => true,
        'sequence' => false,
        'unsigned' => true
        //'comment' => 'Id do módulo do curso'
    ),
    'field5' => array (
        'name' => 'palavra',
        'type' => 'INTEGER',
        'length' => '10',
        'notnull' => true,
        'sequence' => false,
        'unsigned' => true
        //'comment' => 'Id da palavra'
    ),
    'field6' => array (
        'name' => 'letra_escolhida',
        'type' => 'CHAR',
        'notnull' => true,
        'length' => '1'
        //'comment' => 'Letra que o jogador tentou'
    ),
    'field7' => array (
        'name' => 'timestamp',
        'type' => 'INTEGER',
        'length' => '10',
        'notnull' => false,
        'sequence' => false,
        'unsigned' => true,
        //'comment' => 'Tempo em que a jogada foi realizada',
        'default' => 0
    ),
);

$params = array (
    'table_name' => "new_table",
    'structure' => json_encode($structure)
);

/// REST CALL
$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname;
require_once('./curl.php');
$curl = new curl;
//if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
$resp = $curl->post($serverurl . $restformat, array('params' => $params));
print_r($resp);
