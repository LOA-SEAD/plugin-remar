<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once(dirname(__FILE__).'/lib.php');

    // General settings

    $settings->add(
        new admin_setting_configcheckbox(
            'remarmoodle/game1',
            get_string('game1', 'remarmoodle'),
            get_string('game1_config', 'remarmoodle'),
            0
        )
    );

    $settings->add(
        new admin_setting_configcheckbox(
            'remarmoodle/game2',
            get_string('game2', 'remarmoodle'),
            get_string('game2_config', 'remarmoodle'),
            0
        )
    );
}