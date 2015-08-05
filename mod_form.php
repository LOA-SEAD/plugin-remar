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
 * The main remarmoodle configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    mod_remarmoodle
 * @copyright  2015 Rener Baffa da Silva <renerbaffa@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 *
 * @package    mod_remarmoodle
 * @copyright  2015 Rener Baffa da Silva <renerbaffa@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_remarmoodle_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $USER;

        $mform = $this->_form;

        // Adding the "general" fieldset, where all the common settings are showed.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('remarmoodlename', 'remarmoodle'), array('size' => '64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'remarmoodlename', 'remarmoodle');

        // Adding the standard "intro" and "introformat" fields.
        $this->add_intro_editor();

        //$json = file_get_contents('myapp.dev:9090/moodle/moodleGameList');
        
        $curl = new curl();
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $json = $curl->post('myapp.dev:9090/moodle/moodleGameList', array('domain' => $_SERVER['HTTP_HOST']));
        
        $obj = json_decode($json);
        
        $mform->addElement('html', '<div id="test">');
        $mform->addElement('html', '<table>');
        
        foreach($obj->games as $game) {
            $canShow = false;
            foreach ($game->accounts as $acc) {
                if($acc->accountName == $USER->username) {
                    $canShow = true;
                    break;
                }
            }
            
            if($canShow) {
                $mform->addElement('html', '<tr>');
                $mform->addElement('html', '<td>');
                $radio =& $mform->createElement('radio', 'game', '', $game->name, $game->id, null);
                $mform->addElement($radio);
                $mform->addElement('html', '</td>');
                $mform->addElement('html', '<td align="center">');
                $mform->addElement('html', '<label for="id_game_'.$game->id.'">');
                $image =& $mform->createElement('html', '<img src="'.$game->image.'" alt="'.$game->name.'" />');
                $mform->addElement($image);
                $mform->addElement('html', '</label>');
                $mform->addElement('html', '</td>');
                $mform->addElement('html', '</tr>');
            }
        }
        
        $mform->addElement('html', '</table>');
            
        $mform->addElement('html', '</div>');
        //$mform->addGroup($radioarray, 'radioar', 'Jogo a adicionar', array(' '), false);
        
        // Adding the rest of remarmoodle settings, spreading all them into this fieldset
        // ... or adding more fieldsets ('header' elements) if needed for better logic.
        //$mform->addElement('static', 'label1', 'remarmoodlesetting1', 'Your remarmoodle fields go here. Replace me!');

        /*$mform->addElement('header', 'remarmoodlefieldset', get_string('remarmoodlefieldset', 'remarmoodle'));
        $mform->addElement('static', 'label2', 'remarmoodlesetting2', 'Your remarmoodle fields go here. Replace me!');*/

        // Add standard grading elements.
        $this->standard_grading_coursemodule_elements();

        // Add standard elements, common to all modules.
        $this->standard_coursemodule_elements();

        // Add standard buttons, common to all modules.
        $this->add_action_buttons();
    }
}
