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
 * World Campus Coursera-style Marketplace frontpage layout.
 * Pure Bootstrap 5 + Moodle Boost Architecture.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php');
require_once($CFG->dirroot . '/course/lib.php');

$themesettings = new \theme_worldcampus\util\settings();

// Add SEO Meta Tags for frontpage
if (!isloggedin() || isguestuser()) {
    global $DB;

    $sitename = format_string($SITE->fullname);
    $sitesummary = strip_tags($SITE->summary);
    if (empty($sitesummary)) {
        $sitesummary = "World Campus - Global online learning platform offering world-class courses, certificates, and accredited degrees.";
    }

    $totalcourses = $DB->count_records('course', ['visible' => 1]) - 1;
    $totalusers = $DB->count_records('user', ['deleted' => 0, 'suspended' => 0]) - 1;

    $logo = $themesettings->logo;
    if (empty($logo)) {
        $logo = new moodle_url('/theme/worldcampus/pix/logo.png');
        $logo = $logo->out(true);
    }

    $currenturl = $PAGE->url->out(true);
    $metadescription = $sitesummary . " Explore $totalcourses courses with $totalusers+ learners worldwide.";

    $categories = $DB->get_records('course_categories', ['visible' => 1], '', 'name', 0, 10);
    $keywords = [$sitename, 'Online Courses', 'Coursera Style', 'Distance Learning', 'Global Degrees', 'Certificates'];
    foreach ($categories as $cat) {
        $keywords[] = format_string($cat->name);
    }
    $metakeywords = implode(', ', array_slice($keywords, 0, 15));

    $seo_meta = '
    <meta name="description" content="' . s($metadescription) . '">
    <meta name="keywords" content="' . s($metakeywords) . '">
    <meta name="author" content="' . s($sitename) . '">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="' . s($sitename) . '">
    <meta property="og:description" content="' . s($metadescription) . '">
    <meta property="og:url" content="' . s($currenturl) . '">
    <meta property="og:image" content="' . s($logo) . '">
    <meta property="og:site_name" content="' . s($sitename) . '">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="' . s($sitename) . '">
    <meta name="twitter:description" content="' . s($metadescription) . '">
    <meta name="twitter:image" content="' . s($logo) . '">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    ';
    $CFG->additionalhtmlhead .= $seo_meta;
}

$addblockbutton = $OUTPUT->addblockbutton();

if (isloggedin()) {
    $courseindexopen = (get_user_preferences('drawer-open-index', true) == true);
    $blockdraweropen = (get_user_preferences('drawer-open-block') == true);
} else {
    $courseindexopen = false;
    $blockdraweropen = false;
}

$extraclasses = ['uses-drawers', 'worldcampus-marketplace'];
if ($courseindexopen) {
    $extraclasses[] = 'drawer-open-index';
}

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = (strpos($blockshtml, 'data-block=') !== false || !empty($addblockbutton));
if (!$hasblocks) {
    $blockdraweropen = false;
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);

$bodyattributes = $OUTPUT->body_attributes($extraclasses);

// Fetch categories for Coursera category pills
global $DB;
$coursecategories = [];
try {
    $rawcategories = $DB->get_records('course_categories', ['visible' => 1], 'sortorder ASC', 'id, name, coursecount, description', 0, 8);
    foreach ($rawcategories as $cat) {
        $coursecategories[] = [
            'id' => $cat->id,
            'name' => format_string($cat->name),
            'count' => $cat->coursecount,
            'url' => (new moodle_url('/course/index.php', ['categoryid' => $cat->id]))->out(false),
        ];
    }
} catch (\Throwable $e) {
    $coursecategories = [];
}

// Fetch featured/marketplace courses
$marketplacecourses = [];
try {
    $allcourses = enrol_get_all_users_courses(0);
    $count = 0;
    foreach ($allcourses as $c) {
        if ($c->id == SITEID) continue;
        if ($count >= 8) break;

        $courseobj = new \core_course_list_element($c);
        $courseutil = new \theme_worldcampus\util\course($courseobj);
        $contacts = $courseutil->get_course_contacts();
        $instructorname = !empty($contacts) ? $contacts[0]['fullname'] : 'World Faculty';

        $marketplacecourses[] = [
            'id' => $c->id,
            'fullname' => format_string($courseobj->get_formatted_name()),
            'summary' => core_text::substr(strip_tags($courseobj->summary), 0, 140) . '...',
            'image' => $courseutil->get_summary_image(),
            'category' => $courseutil->get_category(),
            'instructor' => $instructorname,
            'url' => (new moodle_url('/course/view.php', ['id' => $c->id]))->out(false),
            'rating' => '4.8',
            'rating_count' => rand(320, 2800),
            'level' => 'Beginner · Certificate',
            'duration' => '3–6 Months',
        ];
        $count++;
    }
} catch (\Throwable $e) {
    $marketplacecourses = [];
}

// Stats metrics
$statcourses = max(1, $DB->count_records('course', ['visible' => 1]) - 1);
$statusers = max(1, $DB->count_records('user', ['deleted' => 0, 'suspended' => 0]) - 1);

// User Resume Course data if logged in
$userresumecourses = [];
$isloggedin = isloggedin() && !isguestuser();
if ($isloggedin) {
    global $USER;
    $mycourses = enrol_get_my_courses(['id', 'fullname', 'summary'], 'visible DESC, fullname ASC', 3);
    foreach ($mycourses as $mc) {
        $cobj = new \core_course_list_element($mc);
        $cutil = new \theme_worldcampus\util\course($cobj);
        $progress = theme_worldcampus_get_course_progress($mc->id, $USER->id);
        $userresumecourses[] = [
            'id' => $mc->id,
            'fullname' => format_string($mc->fullname),
            'image' => $cutil->get_summary_image(),
            'progress' => $progress,
            'url' => (new moodle_url('/course/view.php', ['id' => $mc->id]))->out(false),
        ];
    }
}

$templatecontext = [
    'sitename' => format_string($SITE->fullname, true, ['context' => \core\context\course::instance(SITEID)]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'primarymoremenu' => $primarymenu['moremenu'],
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'addblockbutton' => $addblockbutton,
    'isloggedin' => $isloggedin,
    'user_firstname' => $isloggedin ? $USER->firstname : '',
    'has_resume_courses' => !empty($userresumecourses),
    'resume_courses' => $userresumecourses,
    'categories' => $coursecategories,
    'has_categories' => !empty($coursecategories),
    'marketplace_courses' => $marketplacecourses,
    'has_marketplace_courses' => !empty($marketplacecourses),
    'stat_courses' => $statcourses,
    'stat_users' => number_format($statusers),
    'search_url' => (new moodle_url('/course/search.php'))->out(false),
    'catalog_url' => (new moodle_url('/course/index.php'))->out(false),
    'dashboard_url' => (new moodle_url('/my/'))->out(false),
    'mycourses_url' => (new moodle_url('/my/courses.php'))->out(false),
];

$templatecontext = array_merge($templatecontext, $themesettings->footer());
$templatecontext = array_merge($templatecontext, $themesettings->navbar());

echo $OUTPUT->render_from_template('theme_worldcampus/frontpage', $templatecontext);
