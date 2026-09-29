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
 * World Campus user dashboard layout with React 19 + Shadcn UI mount.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/lib.php');

$bodyattributes = $OUTPUT->body_attributes(['worldcampus-dashboard', 'min-h-screen', 'flex', 'flex-col']);

// Fetch user enrolled courses with progress
$enrolledcourses = enrol_get_my_courses(['id', 'fullname', 'summary', 'enablecompletion', 'category'], 'visible DESC,sortorder ASC');
$coursesdata = [];
$totalprogress = 0;
$coursecount = count($enrolledcourses);

foreach ($enrolledcourses as $c) {
    $progress = theme_worldcampus_get_course_progress($c->id, $USER->id);
    $totalprogress += $progress;
    $coursesdata[] = [
        'id' => (int)$c->id,
        'fullname' => format_string($c->fullname),
        'summary' => strip_tags($c->summary),
        'progress' => (int)$progress,
        'viewurl' => (new moodle_url('/course/view.php', ['id' => $c->id]))->out(false),
    ];
}

$avgprogress = $coursecount > 0 ? round($totalprogress / $coursecount) : 0;

$reactprops = [
    'wwwroot' => $CFG->wwwroot,
    'userFullname' => fullname($USER),
    'courseCount' => $coursecount,
    'averageProgress' => (int)$avgprogress,
    'courses' => $coursesdata,
];

$templatecontext = [
    'sitename' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'react_props_json' => json_encode($reactprops),
    'user_fullname' => fullname($USER),
    'user_menu' => $OUTPUT->user_menu(),
];

echo $OUTPUT->render_from_template('theme_worldcampus/dashboard/dashboard', $templatecontext);
