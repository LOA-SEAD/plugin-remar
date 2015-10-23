<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints a particular instance of remarmoodle
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_remarmoodle
 * @copyright  2015 Rener Baffa da Silva <renerbaffa@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace remarmoodle with the name of your module and remove this line.
require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or

if ($id) {
    $course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
} else {
    error('You must specify a course ID - Você deve especificar o ID do curso');
}

require_login($course, true);

$PAGE->set_course($course);
$PAGE->set_url('/mod/remarmoodle/report.php', array('id' => $id));
$PAGE->set_title("Relatório de uso");
$PAGE->set_heading("Relatório de uso");
$PAGE->set_pagelayout('standard');

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('remarmoodle-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

$table_name = "remarmoodle"."_escola_magica";

$resources = $DB->get_records("remarmoodle", array('course' => $course->id));

if ($resources == null) {
    echo "<h3>Ainda não há jogos neste curso.</h3>";
}
else {
    echo "<center>";
    echo "<div>";
    echo "<select>";
    foreach($resources as $resource) {
        echo '<option value="'.$resource->id.'">'.$resource->name.'</option>';
    }
    echo "</select>";
    echo "</div>";
    echo "<center>";

    /*
    $records = $DB->get_records_sql($table_name, array("course" => $course->id));

    var_dump($records);
    echo "<br />";
    echo "<br />";
    echo "<br />";
    echo "<br />";
    echo "<br />";
    echo "<br />";

    if ($records == null) {
        echo html_writer::label("Ainda não há dados", null);
    }
    else {
        $table = new html_table();
        $table->head = array(
            'Username do usuário',
            //'Módulo do Curso',
            'ID do Recurso do REMAR', 'Enunciado', 'Alternativa A', 'Alternativa B',
            'Alternativa C', 'Alternativa D', 'Resposta Certa', 'Resposta Escolhida', 'Hora');

        $data = array();

        global $USER;

        foreach($records as $record) {
            if ($record->user_id != 0) {
                $currUser = $DB->get_record('user', array('id' => $record->user_id));

                $organized_array['user'] = $currUser->firstname." ".$currUser->lastname;
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
    }*/
}

// Finish the page.
echo $OUTPUT->footer();