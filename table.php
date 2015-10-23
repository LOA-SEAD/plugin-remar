<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');

global $DB, $USER;

$records = $DB->get_records("remarmoodle_escola_magica", array("remar_resource_id" => $_GET['resourceid']));

if ($records == null) {
    echo html_writer::label("Ainda não há dados", null);
}
else {
    echo "<br />";
    $table = new html_table();
    
    $table->head = array(
        'Usuário', /*'Módulo do curso',*/ 'Atividade REMAR', 'Enunciado',
        'Alternativa A', 'Alternativa B', 'Alternativa C', 'Alternativa D',
        'Resposta Correta', 'Resposta Escolhida', 'Data'
    );
    
    $data = array();
    
    foreach($records as $record) {
        if ($record->user_id != 0) {
            $currentUser = $DB->get_record('user', array('id' => $record->user_id));
            
            $organized_array['user'] = $currentUser->firstname." ".$currentUser->lastname;
            //$organized_array['cm'] = $record->cm;
            $organized_array['remar_resource_id'] = $record->remar_resource_id;
            $organized_array['enunciado'] = $record->enunciado;
            $organized_array['alternativaa'] = $record->alternativaa;
            $organized_array['alternativab'] = $record->alternativab;
            $organized_array['alternativac'] = $record->alternativac;
            $organized_array['alternativad'] = $record->alternativad;
            $organized_array['respostacerta'] = $record->respostacerta;
            $organized_array['resposta'] = $record->resposta;
            $organized_array['timestamp'] = date("d/m/Y H:i:s", $record->timestamp);
            array_push($data, $organized_array);
        }
    }
    $table->data = $data;
    
    echo html_writer::table($table);
}

?>