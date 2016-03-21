<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');

//echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>';


function isInArray($array, $value) {
    foreach($array as $obj) {
        if($obj["hash"] == $value) {
            return true;
        }
    }

    return false;
}

//global $DB, $USER;

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "http://localhost:8080/moodle/getLogFromResource",
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
    $users = array();
    $data = array();

    $table = new html_table();
    //$head = array();

    foreach($records as $record) {
        $dataObj = array();
        foreach($record as $key=>$value) {
            if($key == "user" && !isInArray($users, $value)) {
                $userObj["hash"] = $value;
                $userObj["hits"] = 0;
                $userObj["errors"] = 0;
                array_push($users, $userObj);
            }

            if ($key !="game") {
                $dataObj[$key] = $value;
            }
        }
        array_push($data, $dataObj);
    }

    //$table->head = $head;
    
    $table->data = $data;
    
    echo html_writer::table($table);


    echo '<ul class="collapsible" data-collapsible="accordion">
    <li>
      <div class="collapsible-header"><i class="material-icons">filter_drama</i>First</div>
      <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">place</i>Second</div>
      <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">whatshot</i>Third</div>
      <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
    </li>
  </ul>';
}

?>