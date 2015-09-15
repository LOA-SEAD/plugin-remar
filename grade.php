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
 * Redirect the user to the appropriate submission related page
 *
 * @package   mod_remarmoodle
 * @category  grade
 * @copyright 2015 Rener Baffa da Silva <renerbaffa@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . "../../../config.php");
require_once($CFG->dirroot.'/mod/remarmoodle/lib.php');
require_once($CFG->libdir.'/gradelib.php');

$id = required_param('id', PARAM_INT);// Course module ID.
$userid = optional_param('userid', 0, PARAM_INT); // Graded user ID (optional).
$grade = required_param('questions', PARAM_INT); //User grade

if ($id) {
    $cm = get_coursemodule_from_id('remarmoodle', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $remarmoodle = $DB->get_record('remarmoodle', array('id' => $cm->instance), '*', MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course->id, false, $cm);

/*echo 'id: '.$id.'<br /><br /><br />';
echo 'userid: '.var_dump($USER).'<br /><br /><br />';
echo 'grade: '.$grade.'<br /><br /><br />';
echo 'cm: '.var_dump($cm).'<br /><br /><br />';
echo 'course: '.var_dump($course).'<br /><br /><br />';
echo 'remarmoodle: '.var_dump($remarmoodle).'<br /><br /><br /><br /><br /><br /><br /><br />';*/

/*$game = new stdClass();
$game->name = $remarmoodle->name;
$game->course = $course->id;
$game->id = $remarmoodle->id;
$game->rawgrade = $grade;
$game->userid = $userid;*/

$data = new stdClass();
$data->course = $course->id;
$data->id = $remarmoodle->id;
$data->rawgrade = $grade;
$data->name = $remarmoodle->name;
$data->assessed = false;

remarmoodle_update_grades($data, $userid, false);

$message = 'Nota inserida';
redirect('view.php?id='.$id, $message);
/*echo '<pre>';
print_r($data);
echo '</pre>';*/

//echo remarmoodle_grade_item_update($game);