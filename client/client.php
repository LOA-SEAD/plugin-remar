<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$token = '6e5f05d5c4e85787f4f05bdb951c5002';
$domainname = 'localhost/moodle';

/// FUNCTION NAME
$functionname = 'mod_remarmoodle_quiforca_update';
$restformat = 'json';

/// PARAMETERS
$now = new DateTime();
$params = array (
    'userid' => 4,
    'cm' => 2,
    'instance_id' => 2,
    'dica' => 'Dica',
    'palavra' => 'palavra',
    'contribuicao' => 'Rener Baffa da Silva',
    'letra_escolhida' => 'J',
    'timestamp' => $now->getTimestamp()
);

/// REST CALL
$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname;
require_once('./curl.php');
$curl = new curl;
//if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
$resp = $curl->post($serverurl . $restformat, array('params' => $params));
print_r($resp);
