<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$token = '076d1c9abbf7c922b7d2bb519d2dcd45';
$domainname = 'localhost/moodle';

/// FUNCTION NAME
$functionname = 'mod_remarmoodle_token_verifier';
$restformat = 'json';

/// PARAMETERS

/// REST CALL
$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname;
require_once('../curl.php');
$curl = new curl;
//if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
$resp = $curl->post($serverurl . $restformat, array('hash' => '7d4ed1068726d91f7f66c3db7d2f9a27f8a0ca5bf35df32913b48fb8dc5929fb'));
print_r($resp);
