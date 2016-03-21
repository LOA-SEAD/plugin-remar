<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');

//required_param("remar_user_id", PARAM_INT);

require_login();

required_param("hash", PARAM_STRINGID);
$hash = optional_param('hash', 0, PARAM_RAW);

$remarPath = 'http://localhost:8080';
//$PAGE->set_heading(format_string($course->fullname));

global $DB;

$DB->delete_records('remarmoodle_user', array('hash' => $hash));

//header("redirect: " . $remarPath . "/my-profile");
echo '<script type="text/javascript">location.href = "'.$remarPath.'/my-profile";</script>';

?>