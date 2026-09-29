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
 * World Campus login layout.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes(['worldcampus-auth', 'bg-slate-950', 'text-slate-100', 'min-h-screen', 'overflow-x-hidden']);

$templatecontext = [
    'sitename' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'tagline' => theme_worldcampus_get_setting('tagline', 'Connecting You to Global Education'),
    'herotitle' => theme_worldcampus_get_setting('herotitle', 'Empowering Minds Across the Globe'),
    'herosubtitle' => theme_worldcampus_get_setting('herosubtitle', 'Experience world-class online learning with interactive digital classrooms, AI-assisted tutoring, and flexible study pathways.'),
    'sso_url' => new moodle_url('/auth/sso/login.php'),
];

echo $OUTPUT->render_from_template('theme_worldcampus/auth/login', $templatecontext);
