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
 * World Campus login layout with React 19 + Shadcn UI mount.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes(['worldcampus-auth', 'min-h-screen', 'overflow-x-hidden']);

$reactprops = [
    'wwwroot' => $CFG->wwwroot,
    'ssoUrl' => (new moodle_url('/auth/sso/login.php'))->out(false),
    'sitename' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
];

$templatecontext = [
    'sitename' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID)]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'react_props_json' => json_encode($reactprops),
    'sso_url' => (new moodle_url('/auth/sso/login.php'))->out(false),
];

echo $OUTPUT->render_from_template('theme_worldcampus/auth/login', $templatecontext);
