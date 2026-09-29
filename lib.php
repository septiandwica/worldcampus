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
 * World Campus theme functions.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Page initialization callback for theme_worldcampus.
 *
 * @param moodle_page $page
 */
function theme_worldcampus_page_init(moodle_page $page) {
    global $CFG;
    // Add Google Fonts
    $page->requires->css(new moodle_url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=DM+Sans:wght@300;400;500;600;700;800&display=swap'));
    
    // Direct link to compiled World Campus Tailwind & Shadcn stylesheet
    $page->requires->css(new moodle_url('/theme/worldcampus/style/worldcampus.css'));
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_worldcampus_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        $theme = theme_config::load('worldcampus');
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }
    return false;
}

/**
 * Helper to fetch theme settings with defaults.
 *
 * @param string $setting
 * @param mixed $default
 * @return mixed
 */
function theme_worldcampus_get_setting($setting, $default = null) {
    $theme = theme_config::load('worldcampus');
    if (!empty($theme->settings->$setting)) {
        return $theme->settings->$setting;
    }
    return $default;
}

/**
 * Calculate course completion percentage for the current user.
 *
 * @param int $courseid
 * @param int $userid
 * @return int 0-100
 */
function theme_worldcampus_get_course_progress($courseid, $userid = null) {
    global $USER, $DB;
    if (!$userid) {
        $userid = $USER->id;
    }
    if (empty($userid) || $userid <= 0) {
        return 0;
    }

    try {
        $course = $DB->get_record('course', ['id' => $courseid]);
        if (!$course || !$course->enablecompletion) {
            return 0;
        }

        $cinfo = new completion_info($course);
        if (!$cinfo->is_enabled()) {
            return 0;
        }

        $activities = $cinfo->get_activities();
        if (empty($activities)) {
            return 0;
        }

        $completed = 0;
        foreach ($activities as $activity) {
            $data = $cinfo->get_data($activity, false, $userid);
            if ($data->completionstate == COMPLETION_COMPLETE || $data->completionstate == COMPLETION_COMPLETE_PASS) {
                $completed++;
            }
        }

        return round(($completed / count($activities)) * 100);
    } catch (Exception $e) {
        return 0;
    }
}
