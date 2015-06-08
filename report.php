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
$n  = optional_param('n', 0, PARAM_INT);  // ... remarmoodle instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('remarmoodle', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $remarmoodle  = $DB->get_record('remarmoodle', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $remarmoodle  = $DB->get_record('remarmoodle', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $remarmoodle->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('remarmoodle', $remarmoodle->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_remarmoodle\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $remarmoodle);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/remarmoodle/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($remarmoodle->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('remarmoodle-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
//$bla = $DB->get_records('remarmoodle');
//echo '<p>'.var_dump($bla).'</p>';

/*if ($remarmoodle->intro) {
    echo $OUTPUT->box(format_module_intro('remarmoodle', $remarmoodle, $cm->id), 'generalbox mod_introbox', 'remarmoodleintro');
}*/

/*$remarmoodle_content = '<p>'.get_string('test_activity_description', 'remarmoodle').'</p>';
$remarmoodle_content .= '<form method="get" action="grade.php">';
$remarmoodle_content .= '<input type="hidden" name="id" value="'.$cm->id.'" />';
$remarmoodle_content .= '<input type="hidden" name="userid" value="'.$USER->id.'" />';
$remarmoodle_content .= '<input type="number" name="questions" min="0" max="10" /><br />';
$remarmoodle_content .= '<input type="submit" />';
$remarmoodle_content .= '</form>';*/
/*$remarmoodle_content = '<div><iframe src="http://sistemas2.sead.ufscar.br/loa/QuiForca/" height="600" width="900" scrolling=no frameborder="0" /></div>';

echo $remarmoodle_content;*/

/*echo '<pre>';
var_dump($_SESSION);
echo '</pre>';*/

$records = $DB->get_records('remarmoodle_quiforca');
$table = new html_table();
$table->head = array('ID', 'ID do Usuário', 'Módulo do Curso', 'Instance_id', 'Dica', 'Palavra', 'Contribuição', 'Letra Escolhida', 'Data');

$data = array();

foreach($records as $record) {
    $organized_array['id'] = $record->id;
    $organized_array['userid'] = $record->userid;
    $organized_array['cm'] = $record->pontos;
    $organized_array['instanece_id'] = $record->instance_id;
    $organized_array['dica'] = $record->dica;
    $organized_array['palavra'] = $record->palavra;
    $organized_array['contribuicao'] = $record->contribuicao;
    $organized_array['letra_escolhida'] = $record->letra_escolhida;
    $organized_array['timestamp'] = date("d/m/Y h:m:s", $record->timestamp);
    array_push($data, $organized_array);
}

//print_r($data);
$table->data = $data;

echo html_writer::table($table);
/*echo '<pre>';
print_r($records);
echo '</pre>';*/


// Finish the page.
echo $OUTPUT->footer();
