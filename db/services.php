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
 * Theme worldcampus functions and service definitions.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'theme_worldcampus_fontsize' => [
        'classname' => 'theme_worldcampus\api\accessibility',
        'classpath' => 'theme_worldcampus/classes/api/accessibility.php',
        'methodname' => 'fontsize',
        'description' => 'Increase or decrease the site font size.',
        'type' => 'write',
        'ajax' => true,
    ],
    'theme_worldcampus_sitecolor' => [
        'classname' => 'theme_worldcampus\api\accessibility',
        'methodname' => 'sitecolor',
        'description' => 'Changes the site color aspect.',
        'type' => 'write',
        'ajax' => true,
    ],
    'theme_worldcampus_savethemesettings' => [
        'classname' => 'theme_worldcampus\api\accessibility',
        'methodname' => 'savethemesettings',
        'description' => 'Store the user theme settings.',
        'type' => 'write',
        'ajax' => true,
    ],
    'theme_worldcampus_getthemesettings' => [
        'classname' => 'theme_worldcampus\api\accessibility',
        'methodname' => 'getthemesettings',
        'description' => 'Get the user theme settings.',
        'type' => 'read',
        'ajax' => true,
    ],
];
