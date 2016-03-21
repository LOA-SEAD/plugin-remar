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
    $cm         = get_coursemodule_from_id('remarmoodle', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $remarmoodle  = $DB->get_record('remarmoodle', array('id' => $cm->instance), '*', MUST_EXIST);
    /*var_dump($cm);
    echo "<br /><br />";
    var_dump($course);
    echo "<br /><br />";
    var_dump($remarmoodle);*/
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

$remarPath = "http://localhost:8080";

// Output starts here.
echo $OUTPUT->header();

$record = $DB->get_record('remarmoodle', array('id' => $remarmoodle->id));

echo html_writer::start_tag('iframe', array('frameBorder' => "0", 'scrolling' => 'no', 'style' => 'height: '.($record->height+30).'px;width: '.($record->width+30).'px;', 'src' => $remarPath.$record->url));
echo html_writer::end_tag('iframe');

echo $OUTPUT->footer();
