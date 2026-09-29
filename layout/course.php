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
 * World Campus course & topic view layout.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/lib.php');

$bodyattributes = $OUTPUT->body_attributes(['worldcampus-course', 'bg-slate-950', 'text-slate-100', 'min-h-screen', 'flex', 'flex-col']);

$course = $PAGE->course;
$progress = theme_worldcampus_get_course_progress($course->id, $USER->id);

$templatecontext = [
    'sitename' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'course_id' => $course->id,
    'course_fullname' => format_string($course->fullname),
    'course_shortname' => format_string($course->shortname),
    'course_summary' => strip_tags($course->summary),
    'course_progress' => $progress,
    'isediting' => $PAGE->user_is_editing(),
    'edit_url' => new moodle_url('/course/view.php', ['id' => $course->id, 'edit' => $PAGE->user_is_editing() ? 'off' : 'on', 'sesskey' => sesskey()]),
    'user_menu' => $OUTPUT->user_menu(),
];

echo $OUTPUT->render_from_template('theme_worldcampus/core_course/course', $templatecontext);
