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
    'field1' => 'INT',
    'field2' => 'TEXT'
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
