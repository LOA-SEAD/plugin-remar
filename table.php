<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');

//global $DB, $USER;

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "http://localhost:9090/moodle/getLogFromResource",
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => array(
        "resourceId" => $_POST['resourceid'],
    )
));

$json = curl_exec($curl);
curl_close($curl);

$obj = json_decode($json);

$records = $obj->data;

if ($records == null) {
    echo html_writer::label("Ainda não há dados", null);
}
else {
    $table = new html_table();
    $head = array();
    $data;
    $count = 0;

    foreach($records as $record) {
        foreach($record as $key=>$value) {
            if (is_string($value) && $key != "moodle_url") {
                if($count == 0) {
                    array_push($head, $key);
                }
                $data[$count][$key] = $value;
            }
        }
        $count++;
    }

    $table->head = $head;
    
    $table->data = $data;
    
    echo html_writer::table($table);
}

?>