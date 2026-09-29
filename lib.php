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
    // Add Google Fonts
    $page->requires->css(new moodle_url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=DM+Sans:wght@300;400;500;600;700;800&display=swap'));
    
    // Direct link to compiled World Campus Tailwind & Shadcn stylesheet
    $page->requires->css(new moodle_url('/theme/worldcampus/style/worldcampus.css'));
}

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_worldcampus_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = \core\context\system::instance();
    if ($filename == 'default.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    } else if ($filename == 'plain.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');
    } else {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }

    $worldvariables = file_get_contents($CFG->dirroot . '/theme/worldcampus/scss/worldcampus/_variables.scss');
    $worlddefault = file_get_contents($CFG->dirroot . '/theme/worldcampus/scss/default.scss');
    $security = file_get_contents($CFG->dirroot . '/theme/worldcampus/scss/worldcampus/_security.scss');

    $lastpreset = '';
    if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_worldcampus', 'preset', 0, '/', $filename))) {
        $lastpreset = $presetfile->get_content();
    }

    $allscss = $worldvariables . "\n" . $scss . "\n" . $worlddefault . "\n" . $lastpreset . "\n" . $security;
    return $allscss;
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_worldcampus_get_extra_scss($theme) {
    $content = '';

    $loginbgimgurl = $theme->setting_file_url('loginbgimg', 'loginbgimg');
    if (empty($loginbgimgurl)) {
        $loginbgimgurl = new \moodle_url('/theme/worldcampus/pix/loginbg.png');
        $loginbgimgurl->out();
    }

    $content .= 'body.pagelayout-login #page { ';
    $content .= "background-image: url('$loginbgimgurl'); background-size: cover;";
    $content .= ' }';

    return !empty($theme->settings->scss) ? $theme->settings->scss . ' ' . $content : $content;
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_worldcampus_get_pre_scss($theme) {
    $scss = '';
    $configurable = [
        'brandcolor' => ['brand-primary'],
        'secondarymenucolor' => 'secondary-menu-color',
        'fontsite' => 'font-family-sans-serif',
    ];

    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : null;
        if (empty($value)) {
            continue;
        }
        if ($configkey == 'fontsite' && $value == 'Moodle') {
            continue;
        }

        array_map(function($target) use (&$scss, $value) {
            if ($target == 'fontsite') {
                $scss .= '$' . $target . ': "' . $value . '", sans-serif !default' .";\n";
            } else {
                $scss .= '$' . $target . ': ' . $value . ";\n";
            }
        }, (array) $targets);
    }

    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    return $scss;
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
 * @return mixed
 */
function theme_worldcampus_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    $theme = theme_config::load('worldcampus');

    if ($context->contextlevel == CONTEXT_SYSTEM &&
        ($filearea === 'logo' || $filearea === 'logodark' || $filearea === 'footerlogo' || $filearea === 'loginbgimg' || $filearea == 'favicon')) {
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    if ($filearea === 'hvp') {
        return theme_worldcampus_serve_hvp_css($args[1], $theme);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM && preg_match("/^sliderimage[1-9][0-9]?$/", $filearea)) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM && preg_match("/^marketing[1-9][0-9]?icon$/", $filearea)) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM && preg_match("/^recognitionimage[1-9][0-9]?$/", $filearea)) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    send_file_not_found();
}

/**
 * Serves the H5P Custom CSS.
 */
function theme_worldcampus_serve_hvp_css($filename, $theme) {
    global $CFG, $PAGE;

    require_once($CFG->dirroot.'/lib/configonlylib.php');

    $PAGE->set_context(\core\context\system::instance());
    $themename = $theme->name;

    $settings = new \theme_worldcampus\util\settings();
    $content = $settings->hvpcss;

    $md5content = md5($content);
    $md5stored = get_config('theme_worldcampus', 'hvpccssmd5');
    if ((empty($md5stored)) || ($md5stored != $md5content)) {
        set_config('hvpccssmd5', $md5content, $themename);
        $lastmodified = time();
        set_config('hvpccsslm', $lastmodified, $themename);
    } else {
        $lastmodified = get_config($themename, 'hvpccsslm');
        if (empty($lastmodified)) {
            $lastmodified = time();
        }
    }

    $lifetime = 60 * 60 * 24 * 60;

    header('HTTP/1.1 200 OK');
    header('Etag: "'.$md5content.'"');
    header('Content-Disposition: inline; filename="'.$filename.'"');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastmodified).' GMT');
    header('Expires: '.gmdate('D, d M Y H:i:s', time() + $lifetime).' GMT');
    header('Pragma: ');
    header('Cache-Control: public, max-age='.$lifetime);
    header('Accept-Ranges: none');
    header('Content-Type: text/css; charset=utf-8');
    if (!min_enable_zlib_compression()) {
        header('Content-Length: '.strlen($content));
    }

    echo $content;
    die;
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

        $iscomplete = $cinfo->is_course_complete($userid);
        if ($iscomplete) {
            return 100;
        }

        $activities = $cinfo->get_activities();
        if (empty($activities)) {
            return 0;
        }

        $completed = 0;
        $total = count($activities);

        foreach ($activities as $activity) {
            $data = $cinfo->get_data($activity, false, $userid);
            if ($data->completionstate == COMPLETION_COMPLETE || $data->completionstate == COMPLETION_COMPLETE_PASS) {
                $completed++;
            }
        }

        return $total > 0 ? (int) round(($completed / $total) * 100) : 0;
    } catch (\Throwable $e) {
        return 0;
    }
}

/**
 * Returns the management menu items if the user has permission.
 *
 * @return array|null
 */
function theme_worldcampus_get_management_menu() {
    if (!isloggedin() || isguestuser()) {
        return null;
    }

    $isadmin = is_siteadmin();
    $systemcontext = \core\context\system::instance();
    
    $canmanageusers = $isadmin || has_capability('moodle/user:update', $systemcontext);
    $canmanagecourses = $isadmin || has_capability('moodle/course:update', $systemcontext);

    if (!$canmanageusers && !$canmanagecourses) {
        return null;
    }

    $items = [];

    if ($canmanageusers) {
        $items[] = [
            'text' => 'Browse list of users',
            'url' => new \moodle_url('/admin/user.php'),
            'icon' => 'fa-users'
        ];
        $items[] = [
            'text' => 'Upload users',
            'url' => new \moodle_url('/admin/tool/uploaduser/index.php'),
            'icon' => 'fa-user-plus'
        ];
    }

    if ($canmanagecourses) {
        $items[] = [
            'text' => 'Manage courses and categories',
            'url' => new \moodle_url('/course/management.php'),
            'icon' => 'fa-graduation-cap'
        ];
        $items[] = [
            'text' => 'Upload courses',
            'url' => new \moodle_url('/admin/tool/uploadcourse/index.php'),
            'icon' => 'fa-upload'
        ];
    }

    if ($isadmin) {
        $items[] = [
            'text' => 'Theme Selector',
            'url' => new \moodle_url('/admin/themeselector.php'),
            'icon' => 'fa-paint-brush'
        ];
    }

    if (empty($items)) {
        return null;
    }

    return [
        'has_items' => true,
        'items' => $items
    ];
}

/**
 * Extends the primary navigation with custom items.
 *
 * @param \core\navigation\views\primary $navigation
 */
function theme_worldcampus_extend_navigation_primary(\core\navigation\views\primary $navigation) {
    if (!isloggedin() || isguestuser()) {
        return;
    }

    $isadmin = is_siteadmin();
    $systemcontext = \core\context\system::instance();
    
    $canmanageusers = $isadmin || has_capability('moodle/user:update', $systemcontext);
    $canmanagecourses = $isadmin || has_capability('moodle/course:update', $systemcontext);

    if (!$canmanageusers && !$canmanagecourses) {
        return;
    }

    $managenode = $navigation->add('Manage', null, \core\navigation\navigation_node::TYPE_CONTAINER, null, 'management_menu');
    
    if ($canmanageusers) {
        $managenode->add('Browse list of users', new \moodle_url('/admin/user.php'), \core\navigation\navigation_node::TYPE_CUSTOM);
        $managenode->add('Upload users', new \moodle_url('/admin/tool/uploaduser/index.php'), \core\navigation\navigation_node::TYPE_CUSTOM);
    }

    if ($canmanagecourses) {
        $managenode->add('Manage courses and categories', new \moodle_url('/course/management.php'), \core\navigation\navigation_node::TYPE_CUSTOM);
        $managenode->add('Upload courses', new \moodle_url('/admin/tool/uploadcourse/index.php'), \core\navigation\navigation_node::TYPE_CUSTOM);
    }

    if ($isadmin) {
        $managenode->add('Theme Selector', new \moodle_url('/admin/themeselector.php'), \core\navigation\navigation_node::TYPE_CUSTOM);
    }
}
