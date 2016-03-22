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

if ($records != null) {
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


    echo '
    <ul class="collapsible">
        <li class="c">
            <div class="collapsible-header">
                <div class="my-div centered"><b>Usuário</b></div>
                <div class="my-div centered"><b>Acertos</b></div>
                <div class="my-div centered"><b>Erros</b></div>
                <div class="my-div centered"><b>Aproveitamento</b></div>
            </div>
        </li>
        <li>
            <div class="collapsible-header">
                <div class="my-div">Rener Baffa da Silva</div>
                <div class="my-div centered">33</div>
                <div class="my-div centered">10</div>
                <div class="my-div centered">74%</div>
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
                            </thead>
                            <tr>
                                <td>Enunciado</td>
                                <td>Alternativa A</td>
                                <td>Alternativa B</td>
                                <td>Alternativa C</td>
                                <td class="centered">Alternativa D</td>
                                <td class="centered">B</td>
                                <td class="centered">A</td>
                                <td class="centered">25/02/2016 22:00</td>
                            </tr>
                            <tr>
                                <td>Enunciado</td>
                                <td>Alternativa A</td>
                                <td>Alternativa B</td>
                                <td>Alternativa C</td>
                                <td class="centered">Alternativa D</td>
                                <td class="centered">B</td>
                                <td class="centered">A</td>
                                <td class="centered">25/02/2016 22:00</td>
                            </tr>
                            <tr>
                                <td>Enunciado</td>
                                <td>Alternativa A</td>
                                <td>Alternativa B</td>
                                <td>Alternativa C</td>
                                <td class="centered">Alternativa D</td>
                                <td class="centered">B</td>
                                <td class="centered">A</td>
                                <td class="centered">25/02/2016 22:00</td>
                            </tr>
                            <tr>
                                <td>Enunciado</td>
                                <td>Alternativa A</td>
                                <td>Alternativa B</td>
                                <td>Alternativa C</td>
                                <td class="centered">Alternativa D</td>
                                <td class="centered">B</td>
                                <td class="centered">A</td>
                                <td class="centered">25/02/2016 22:00</td>
                            </tr>
                            <tr>
                                <td>Enunciado</td>
                                <td>Alternativa A</td>
                                <td>Alternativa B</td>
                                <td>Alternativa C</td>
                                <td class="centered">Alternativa D</td>
                                <td class="centered">B</td>
                                <td class="centered">A</td>
                                <td class="centered">25/02/2016 22:00</td>
                            </tr>
                        </table>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header">
                <div class="my-div">Rener Baffa da Silva</div>
                <div class="my-div centered">33</div>
                <div class="my-div centered">10</div>
                <div class="my-div centered">74%</div>
            </div>
            <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
        </li>
        <li>
            <div class="collapsible-header">
                <div class="my-div">Rener Baffa da Silva</div>
                <div class="my-div centered">33</div>
                <div class="my-div centered">10</div>
                <div class="my-div centered">74%</div>
            </div>
            <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
        </li>
    </ul>';
}

?>