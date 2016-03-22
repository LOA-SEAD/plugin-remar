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
echo '<link rel="stylesheet" type="text/css" href="estilo.css">';


function isInArray($array, $value) {
    foreach($array as $obj) {
        if($obj["hash"] == $value) {
            return true;
        }
    }

    return false;
}

global $DB, $USER;

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
    $data = array();
    $users = array();
    $questions = array();

    foreach($records as $record) {
        $questionObj = array();
        $current = '';
        foreach($record as $key=>$value) {
            if($key == 'user') {
                $current = $value;

                if(!isInArray($users, $value)) {
                    $userObj["hash"] = $value;
                    $userObj["hits"] = 0;
                    $userObj["errors"] = 0;
                    $currUser = $DB->get_record('remarmoodle_user', array('hash' => $value));
                    $currUser = $DB->get_record('user', array('username' => $currUser->moodle_username));
                    $userObj["name"] = $currUser->firstname." ".$currUser->lastname;
                    array_push($users, $userObj);
                }
            }
            else
                if ($key !="game") {
                    if($key == "timestamp") {
                        $value = str_replace("Z", "", $value);
                        $splitted = explode("T", $value);
                        $value = $splitted[0]." ".$splitted[1];
                        $questionObj[$key] = $value;
                    }
                    $questionObj[$key] = $value;
                }
        }


        for($i = 0; $i < count($users); $i++) {
            if($users[$i]["hash"] == $current) {
                if($questionObj["resposta"] == $questionObj["respostacerta"]) {
                    $users[$i]["hits"]++;
                }
                else {
                    $users[$i]["errors"]++;
                }
            }
        }

        if(!array_key_exists($current, $questions)) {
            $questions[$current] = array();
        }

        array_push($questions[$current], $questionObj);
    }

    $output = '
    <ul class="collapsible">
        <li class="c">
            <div class="collapsible-header">
                <div class="my-div centered"><b>Usuário</b></div>
                <div class="my-div centered"><b>Acertos</b></div>
                <div class="my-div centered"><b>Erros</b></div>
                <div class="my-div centered"><b>Aproveitamento</b></div>
            </div>
        </li>';

    foreach($users as $user) {
        $res = 100 * $user["hits"] / ($user["hits"] + $user["errors"]);
        $output .=
            '<li>
                <div class="collapsible-header">
                    <div class="my-div">'.$user["name"].'</div>
                    <div class="my-div centered">'.$user["hits"].'</div>
                    <div class="my-div centered">'.$user["errors"].'</div>
                    <div class="my-div centered">'.round($res, 2).'%</div>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible no-margin">
                        <li class="c">
                            <table style="width: 100%; display: table; border-collapse: collapse; border-spacing: 0;">
                                <thead style="border-bottom: 1px solid #d0d0d0;">
                                    <th class="centered">Enunciado</th>
                                    <th class="centered">Alternativa A</th>
                                    <th class="centered">Alternativa B</th>
                                    <th class="centered">Alternativa C</th>
                                    <th class="centered">Alternativa D</th>
                                    <th class="centered">Resposta Certa</th>
                                    <th class="centered">Resposta Escolhida</th>
                                    <th class="centered">Timestamp</th>
                                </thead>';
                                foreach($questions[$user["hash"]] as $question) {
                                    $output .=
                                    '<tr>
                                        <td>'.$question["enunciado"].'</td>
                                        <td>'.$question["alternativaa"].'</td>
                                        <td>'.$question["alternativab"].'</td>
                                        <td>'.$question["alternativac"].'</td>
                                        <td>'.$question["alternativad"].'</td>
                                        <td class="centered">'.$question["respostacerta"].'</td>
                                        <td class="centered">'.$question["resposta"].'</td>
                                        <td class="centered">'.$question["timestamp"].'</td>
                                    </tr>';
                                }

                                $output .=
                            '</table>
                        </li>
                    </ul>
                </div>
            </li>';
    }

    echo $output;


}

?>