<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');

//required_param("remar_user_id", PARAM_INT);

require_login();

required_param("hash", PARAM_STRINGID);
$hash = optional_param('hash', 0, PARAM_RAW);

$confirmed = optional_param('confirmed', 0, PARAM_RAW);

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/mod/remarmoodle/new-account-confirmation.php', array("hash" => "hash"));
$PAGE->set_title("Confimação de vinculação e conta do Moodle com o REMAR");
$PAGE->set_pagelayout('base');
//$PAGE->set_heading(format_string($course->fullname));

global $USER, $DB;

echo $OUTPUT->header();

$not_used = $DB->get_record('remarmoodle_user', array('moodle_username' => $USER->username));

if ($confirmed == true) {
    link_remar_user_to_moodle($hash, $USER->username);

    $fromUser = new stdClass();
    $fromUser->email = "remar@dc.ufscar.br";
    $fromUser->firstname = "REMAR";
    $fromUser->lastname = "REMAR";
    $fromUser->maildisplay = true;
    $fromUser->mailformat = 1;
    $fromUser->id = -99;

    $toUser = new stdClass();
    $toUser->email = $USER->email;
    $toUser->firstname = $USER->firstname;
    $toUser->lastname = $USER->lastname;
    $toUser->maildisplay = true;
    $toUser->mailformat = 1;
    $toUser->id = $USER->id;
    
    $subject = "Email de confirmação de vínculo do REMAR com o Moodle";
    $messageHtml = 'Olá, '.$USER->firstname.'.<br />'
            . 'Você acabou de vincular sua conta do REMAR com o Moodle.'
            . '<br />Caso este email remeta a uma ação não tomada por você, por favor entre em contato conosco: <a href="mailto:remar@dc.ufscar.br">remar@dc.ufscar.br</a>';
    $messageText = html_to_text($messageHtml);

    email_to_user($toUser, $fromUser, $subject, $messageText, $messageHtml, ",", true);
    
    echo '<script type="text/javascript">location.href = "http://localhost:9090/moodle/confirm/'.$hash.'?username='.$USER->username.'";</script>';
}
else {
    if ($not_used != false) {
        $message = "O usuário '".$USER->username."' já tem uma conta vinculada com o REMAR.";
        $yes_url = new moodle_url('http://localhost:9090/dashboard');
        $no_url = new moodle_url('http://localhost:9090/dashboard');
        echo $OUTPUT->confirm($message, $yes_url, $no_url);
    }
    else {        
        $params = array('hash' => $hash, 'confirmed' => 'true');

        $message = "Tem certeza que deseja vincular sua conta no REMAR com sua conta '".$USER->username."' neste moodle?";
        $yes_url = new moodle_url($PAGE->url, $params);
        $no_url = new moodle_url('http://localhost:9090/dashboard');
        echo $OUTPUT->confirm($message, $yes_url, $no_url);
    }
}

echo $OUTPUT->footer();

?>