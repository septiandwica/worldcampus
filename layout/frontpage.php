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
 * World Campus frontpage layout.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/lib.php');

$bodyattributes = $OUTPUT->body_attributes(['worldcampus-frontpage', 'bg-slate-950', 'text-slate-100', 'min-h-screen', 'flex', 'flex-col']);

// Fetch active courses for frontpage showcase
$courses = enrol_get_all_users_courses(0);
$courselist = [];
$count = 0;
foreach ($courses as $c) {
    if ($c->id == SITEID) continue;
    if ($count >= 6) break;
    $courselist[] = [
        'id' => $c->id,
        'fullname' => format_string($c->fullname),
        'summary' => strip_tags($c->summary),
        'viewurl' => new moodle_url('/course/view.php', ['id' => $c->id]),
        'category' => $c->category,
    ];
    $count++;
}

$templatecontext = [
    'sitename' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'tagline' => theme_worldcampus_get_setting('tagline', 'Connecting You to Global Education'),
    'herotitle' => theme_worldcampus_get_setting('herotitle', 'Empowering Minds Across the Globe'),
    'herosubtitle' => theme_worldcampus_get_setting('herosubtitle', 'Experience world-class online learning with interactive digital classrooms, AI-assisted tutoring, and flexible study pathways.'),
    'herobuttontext' => theme_worldcampus_get_setting('herobuttontext', 'Explore Global Courses'),
    'herobuttonurl' => theme_worldcampus_get_setting('herobuttonurl', '/course/index.php'),
    'has_courses' => !empty($courselist),
    'courses' => $courselist,
    'isloggedin' => isloggedin() && !isguestuser(),
    'user_menu' => $OUTPUT->user_menu(),
];

echo $OUTPUT->render_from_template('theme_worldcampus/frontpage/frontpage', $templatecontext);
