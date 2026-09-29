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
 * World Campus My Courses catalog layout with React 19 + Shadcn UI mount.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/lib.php');

$bodyattributes = $OUTPUT->body_attributes(['worldcampus-mycourses', 'min-h-screen', 'flex', 'flex-col']);

// Fetch user enrolled courses
$enrolledcourses = enrol_get_my_courses(['id', 'fullname', 'summary', 'enablecompletion', 'category'], 'visible DESC,sortorder ASC');
$coursesdata = [];

foreach ($enrolledcourses as $c) {
    $progress = theme_worldcampus_get_course_progress($c->id, $USER->id);
    $coursesdata[] = [
        'id' => (int)$c->id,
        'fullname' => format_string($c->fullname),
        'summary' => strip_tags($c->summary),
        'progress' => (int)$progress,
        'is_completed' => $progress >= 100,
        'viewurl' => (new moodle_url('/course/view.php', ['id' => $c->id]))->out(false),
    ];
}

$reactprops = [
    'wwwroot' => $CFG->wwwroot,
    'courses' => $coursesdata,
    'courseCount' => count($coursesdata),
];

$templatecontext = [
    'sitename' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'react_props_json' => json_encode($reactprops),
    'user_menu' => $OUTPUT->user_menu(),
];

echo $OUTPUT->render_from_template('theme_worldcampus/mycourses', $templatecontext);
