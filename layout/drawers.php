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
 * World Campus base drawers layout with React 19 + Shadcn UI mount.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php');
require_once($CFG->dirroot . '/course/lib.php');

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = !empty(trim($blockshtml));

$bodyattributes = $OUTPUT->body_attributes(['worldcampus-theme', 'min-h-screen', 'flex', 'flex-col']);

$reactnavbarprops = [
    'wwwroot' => $CFG->wwwroot,
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID)]),
    'userFullname' => fullname($USER),
    'userEmail' => $USER->email ?? '',
    'userAvatar' => (new moodle_url('/user/pix.php/' . $USER->id . '/f1.jpg'))->out(false),
    'isLoggedIn' => isloggedin() && !isguestuser(),
    'sesskey' => sesskey(),
];

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID)]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'react_navbar_props_json' => json_encode($reactnavbarprops),
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'user_menu' => $OUTPUT->user_menu(),
];

echo $OUTPUT->render_from_template('theme_worldcampus/drawers', $templatecontext);
