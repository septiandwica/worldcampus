<?php
// This file is part of Ranking block for Moodle - http://moodle.org/
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
 * Theme worldcampus block settings file
 *
 * @package   theme_worldcampus
 * @copyright 2025 Septian Dwi Cahyo(@septian.dwica) - https://samastanuswantara.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {

    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingworldcampus', get_string('configtitle', 'theme_worldcampus'));

    /*
    * ----------------------
    * General settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_worldcampus_general', get_string('generalsettings', 'theme_worldcampus'));

    // Logo file setting.
    $name = 'theme_worldcampus/logo';
    $title = get_string('logo', 'theme_worldcampus');
    $description = get_string('logodesc', 'theme_worldcampus');
    $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, $opts);
    $page->add($setting);

    // Dark Logo file setting.
    $name = 'theme_worldcampus/logodark';
    $title = get_string('logodark', 'theme_worldcampus');
    $description = get_string('logodarkdesc', 'theme_worldcampus');
    $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logodark', 0, $opts);
    $page->add($setting);

    // Favicon setting.
    $name = 'theme_worldcampus/favicon';
    $title = get_string('favicon', 'theme_worldcampus');
    $description = get_string('favicondesc', 'theme_worldcampus');
    $opts = ['accepted_types' => ['.ico'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0, $opts);
    $page->add($setting);

    // Preset.
    $name = 'theme_worldcampus/preset';
    $title = get_string('preset', 'theme_worldcampus');
    $description = get_string('preset_desc', 'theme_worldcampus');
    $default = 'default.scss';

    $context = \core\context\system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_worldcampus', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_worldcampus/presetfiles';
    $title = get_string('presetfiles', 'theme_worldcampus');
    $description = get_string('presetfiles_desc', 'theme_worldcampus');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        ['maxfiles' => 10, 'accepted_types' => ['.scss']]);
    $page->add($setting);

    // Login page background image.
    $name = 'theme_worldcampus/loginbgimg';
    $title = get_string('loginbgimg', 'theme_worldcampus');
    $description = get_string('loginbgimg_desc', 'theme_worldcampus');
    $opts = ['accepted_types' => ['.png', '.jpg', '.svg']];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbgimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $brand-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_worldcampus/brandcolor';
    $title = get_string('brandcolor', 'theme_worldcampus');
    $description = get_string('brandcolor_desc', 'theme_worldcampus');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#0f47ad');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $navbar-header-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_worldcampus/secondarymenucolor';
    $title = get_string('secondarymenucolor', 'theme_worldcampus');
    $description = get_string('secondarymenucolor_desc', 'theme_worldcampus');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#0f47ad');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $fontsarr = [
        'Moodle' => 'Moodle Font',
        'Roboto' => 'Roboto',
        'Poppins' => 'Poppins',
        'Montserrat' => 'Montserrat',
        'Open Sans' => 'Open Sans',
        'Lato' => 'Lato',
        'Raleway' => 'Raleway',
        'Inter' => 'Inter',
        'Nunito' => 'Nunito',
        'Encode Sans' => 'Encode Sans',
        'Work Sans' => 'Work Sans',
        'Oxygen' => 'Oxygen',
        'Manrope' => 'Manrope',
        'Sora' => 'Sora',
        'Epilogue' => 'Epilogue',
    ];

    $name = 'theme_worldcampus/fontsite';
    $title = get_string('fontsite', 'theme_worldcampus');
    $description = get_string('fontsite_desc', 'theme_worldcampus');
    $setting = new admin_setting_configselect($name, $title, $description, 'Poppins', $fontsarr);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_worldcampus/enablecourseindex';
    $title = get_string('enablecourseindex', 'theme_worldcampus');
    $description = get_string('enablecourseindex_desc', 'theme_worldcampus');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $name = 'theme_worldcampus/enableclassicbreadcrumb';
    $title = get_string('enableclassicbreadcrumb', 'theme_worldcampus');
    $description = get_string('enableclassicbreadcrumb_desc', 'theme_worldcampus');
    $default = 0;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $name = 'theme_worldcampus/navbartype';
    $title = get_string('navbartype', 'theme_worldcampus');
    $description = get_string('navbartype_desc', 'theme_worldcampus');
    $default = 'normal';
    $choices = [
        'normal' => get_string('navbartype_normal', 'theme_worldcampus'),
        'floating' => get_string('navbartype_floating', 'theme_worldcampus'),
        'sticky' => get_string('navbartype_sticky', 'theme_worldcampus'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $name = 'theme_worldcampus/enabledarkmode';
    $title = get_string('enabledarkmode', 'theme_worldcampus');
    $description = get_string('enabledarkmode_desc', 'theme_worldcampus');
    $default = 0;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);

    /*
    * ----------------------
    * Advanced settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_worldcampus_advanced', get_string('advancedsettings', 'theme_worldcampus'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_worldcampus/scsspre',
        get_string('rawscsspre', 'theme_worldcampus'), get_string('rawscsspre_desc', 'theme_worldcampus'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_worldcampus/scss', get_string('rawscss', 'theme_worldcampus'),
        get_string('rawscss_desc', 'theme_worldcampus'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Google analytics block.
    $name = 'theme_worldcampus/googleanalytics';
    $title = get_string('googleanalytics', 'theme_worldcampus');
    $description = get_string('googleanalyticsdesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // H5P custom CSS.
    $setting = new admin_setting_configtextarea('theme_worldcampus/hvpcss', get_string('hvpcss', 'theme_worldcampus'), get_string('hvpcss_desc', 'theme_worldcampus'), '');
    $page->add($setting);

    $settings->add($page);

    /*
    * ----------------------
    * Guest Pages tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_worldcampus_guestpages', get_string('guestpages', 'theme_worldcampus'));

    // Number of custom pages.
    $name = 'theme_worldcampus/custompage_count';
    $title = get_string('custompage_count', 'theme_worldcampus');
    $description = get_string('custompage_count_desc', 'theme_worldcampus');
    $default = 3;
    $choices = array_combine(range(1, 10), range(1, 10));
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $count = get_config('theme_worldcampus', 'custompage_count');
    if (!$count) $count = 3;

    $defaults = [
        1 => ['slug' => 'programs', 'title' => 'Programs', 'content' => ''],
        2 => ['slug' => 'faq', 'title' => 'FAQ', 'content' => ''],
        3 => ['slug' => 'about', 'title' => 'About Us', 'content' => '']
    ];

    for ($i = 1; $i <= $count; $i++) {
        $page->add(new admin_setting_heading("theme_worldcampus/custompage_h$i", "Custom Page #$i", ""));

        // Title.
        $name = "theme_worldcampus/custompage_title_$i";
        $title = "Page Title";
        $titleval = get_config('theme_worldcampus', "custompage_title_$i") ?: (isset($defaults[$i]) ? $defaults[$i]['title'] : "Custom Page $i");
        $slug = preg_replace('/-+/', '-', trim(preg_replace('/[^a-zA-Z0-9]/', '-', strtolower($titleval)), '-'));
        $description = "<strong>URL Reference:</strong> <code>/" . $slug . "/</code><br><small>Use this reference link if you want to place it manually in a button, menu, or footer.</small>";
        $default = isset($defaults[$i]) ? $defaults[$i]['title'] : "Custom Page $i";
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

        // Show in navbar.
        $name = "theme_worldcampus/custompage_navbar_$i";
        $title = get_string('custompage_navbar', 'theme_worldcampus');
        $description = get_string('custompage_navbar_desc', 'theme_worldcampus');
        $default = 0;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $page->add($setting);

        // Content.
        $name = "theme_worldcampus/custompage_content_$i";
        $title = "Page Content";
        $description = "";
        $default = isset($defaults[$i]) ? $defaults[$i]['content'] : "No content yet.";
        $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_RAW);
        $page->add($setting);
    }

    $settings->add($page);

    /*
    * -----------------------
    * Maintenance tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_worldcampus_maintenance', get_string('maintenancesettings', 'theme_worldcampus'));

    // Enable maintenance (Core setting).
    $name = 'maintenance_enabled';
    $title = get_string('enablemaintenance', 'theme_worldcampus');
    $description = get_string('enablemaintenance_desc', 'theme_worldcampus');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    // Maintenance message (Core setting).
    $name = 'maintenance_message';
    $title = get_string('maintenancemessage', 'theme_worldcampus');
    $description = get_string('maintenancemessage_desc', 'theme_worldcampus');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $page->add($setting);

    // Maintenance countdown (Theme setting).
    $name = 'theme_worldcampus/maintenancedatetime';
    $title = get_string('maintenancedatetime', 'theme_worldcampus');
    $description = get_string('maintenancedatetime_desc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
    $page->add($setting);

    $settings->add($page);

    /*
    * -----------------------
    * Frontpage settings tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_worldcampus_frontpage', get_string('frontpagesettings', 'theme_worldcampus'));

    // Disable teachers from cards.
    $name = 'theme_worldcampus/disableteacherspic';
    $title = get_string('disableteacherspic', 'theme_worldcampus');
    $description = get_string('disableteacherspicdesc', 'theme_worldcampus');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Slideshow.
    $name = 'theme_worldcampus/slidercount';
    $title = get_string('slidercount', 'theme_worldcampus');
    $description = get_string('slidercountdesc', 'theme_worldcampus');
    $default = 3;
    $options = [];
    for ($i = 0; $i < 13; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // If we don't have an slide yet, default to the preset.
    $slidercount = get_config('theme_worldcampus', 'slidercount');

    if (!$slidercount) {
        $slidercount = $default;
    }

    if ($slidercount) {
        for ($sliderindex = 1; $sliderindex <= $slidercount; $sliderindex++) {
            $fileid = 'sliderimage' . $sliderindex;
            $name = 'theme_worldcampus/sliderimage' . $sliderindex;
            $title = get_string('sliderimage', 'theme_worldcampus');
            $description = get_string('sliderimagedesc', 'theme_worldcampus');
            $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
            $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
            $page->add($setting);

            $name = 'theme_worldcampus/slidertitle' . $sliderindex;
            $title = get_string('slidertitle', 'theme_worldcampus');
            $description = get_string('slidertitledesc', 'theme_worldcampus');
            $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
            $page->add($setting);

            $name = 'theme_worldcampus/slidercap' . $sliderindex;
            $title = get_string('slidercaption', 'theme_worldcampus');
            $description = get_string('slidercaptiondesc', 'theme_worldcampus');
            $default = '';
            $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
            $page->add($setting);
        }

        // Slider CTA 1.
        $name = 'theme_worldcampus/slidercta1text';
        $title = get_string('slidercta1text', 'theme_worldcampus');
        $description = get_string('slidercta1textdesc', 'theme_worldcampus');
        $default = 'Apply Now';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
        $page->add($setting);

        $name = 'theme_worldcampus/slidercta1url';
        $title = get_string('slidercta1url', 'theme_worldcampus');
        $description = get_string('slidercta1urldesc', 'theme_worldcampus');
        $default = 'https://admission.worldcampus.ac.id/join';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $page->add($setting);

        // Slider CTA 2.
        $name = 'theme_worldcampus/slidercta2text';
        $title = get_string('slidercta2text', 'theme_worldcampus');
        $description = get_string('slidercta2textdesc', 'theme_worldcampus');
        $default = 'Explore Programs';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
        $page->add($setting);

        $name = 'theme_worldcampus/slidercta2url';
        $title = get_string('slidercta2url', 'theme_worldcampus');
        $description = get_string('slidercta2urldesc', 'theme_worldcampus');
        $default = 'https://worldcampus.ac.id';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $page->add($setting);
    }

    $setting = new admin_setting_heading('slidercountseparator', '', '<hr>');
    $page->add($setting);

    $name = 'theme_worldcampus/displaymarketingbox';
    $title = get_string('displaymarketingboxes', 'theme_worldcampus');
    $description = get_string('displaymarketingboxesdesc', 'theme_worldcampus');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Recognition logos.
    $setting = new admin_setting_heading('recognitionseparator', '', '<hr>');
    $page->add($setting);

    $name = 'theme_worldcampus/recognitioncount';
    $title = get_string('recognitioncount', 'theme_worldcampus');
    $description = get_string('recognitioncountdesc', 'theme_worldcampus');
    $default = 6;
    $options = [];
    for ($i = 0; $i <= 10; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $recognitioncount = get_config('theme_worldcampus', 'recognitioncount');
    if ($recognitioncount) {
        for ($i = 1; $i <= $recognitioncount; $i++) {
            $fileid = 'recognitionimage' . $i;
            $name = 'theme_worldcampus/recognitionimage' . $i;
            $title = get_string('recognitionimage', 'theme_worldcampus') . ' ' . $i;
            $description = get_string('recognitionimagedesc', 'theme_worldcampus');
            $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.svg'], 'maxfiles' => 1];
            $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
            $page->add($setting);
        }
    }

    $displaymarketingbox = get_config('theme_worldcampus', 'displaymarketingbox');

    if ($displaymarketingbox) {
        // Marketingheading.
        $name = 'theme_worldcampus/marketingheading';
        $title = get_string('marketingsectionheading', 'theme_worldcampus');
        $default = 'OUR FACULTIES';
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $page->add($setting);

        // Marketingcontent.
        $name = 'theme_worldcampus/marketingcontent';
        $title = get_string('marketingsectioncontent', 'theme_worldcampus');
        $default = 'We offer our students comprehensive programs that enrich their education through multidisciplinary, cross-faculty approaches and a wide range of major options.';
        $setting = new admin_setting_confightmleditor($name, $title, '', $default);
        $page->add($setting);

        for ($i = 1; $i < 8; $i++) {
            $filearea = "marketing{$i}icon";
            $name = "theme_worldcampus/$filearea";
            $title = get_string('marketingicon', 'theme_worldcampus', $i . '');
            $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg']];
            $setting = new admin_setting_configstoredfile($name, $title, '', $filearea, 0, $opts);
            $page->add($setting);

            $name = "theme_worldcampus/marketing{$i}heading";
            $title = get_string('marketingheading', 'theme_worldcampus', $i . '');
            $default = 'Faculty';
            $setting = new admin_setting_configtext($name, $title, '', $default);
            $page->add($setting);

          
        }

        $setting = new admin_setting_heading('displaymarketingboxseparator', '', '<hr>');
        $page->add($setting);
    }

    // Enable or disable Numbers sections settings.
    $name = 'theme_worldcampus/numbersfrontpage';
    $title = get_string('numbersfrontpage', 'theme_worldcampus');
    $description = get_string('numbersfrontpagedesc', 'theme_worldcampus');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $numbersfrontpage = get_config('theme_worldcampus', 'numbersfrontpage');

    if ($numbersfrontpage) {
        $name = 'theme_worldcampus/numbersfrontpagecontent';
        $title = get_string('numbersfrontpagecontent', 'theme_worldcampus');
        $description = get_string('numbersfrontpagecontentdesc', 'theme_worldcampus');
        $default = get_string('numbersfrontpagecontentdefault', 'theme_worldcampus');
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $page->add($setting);
    }

    // Fetch courses and categories dynamically for the multiselect settings.
    global $DB;
    
    $coursechoices = [];
    try {
        $courses = $DB->get_records('course', [], 'fullname ASC', 'id, fullname');
        if ($courses) {
            foreach ($courses as $c) {
                if ($c->id == SITEID) {
                    continue;
                }
                $coursechoices[$c->id] = format_string($c->fullname);
            }
        }
    } catch (\Exception $e) {
        // Fallback or empty if DB is not ready during install/upgrade.
    }
    
    $categorychoices = [];
    try {
        $categories = $DB->get_records('course_categories', [], 'name ASC', 'id, name');
        if ($categories) {
            foreach ($categories as $cat) {
                $categorychoices[$cat->id] = format_string($cat->name);
            }
        }
    } catch (\Exception $e) {
        // Fallback or empty if DB is not ready.
    }

    // Custom Courses section.
    $setting = new admin_setting_heading('frontpagecoursesheading', get_string('frontpage_courses_heading', 'theme_worldcampus'), '');
    $page->add($setting);

    $name = 'theme_worldcampus/frontpage_courses_enable';
    $title = get_string('frontpage_courses_enable', 'theme_worldcampus');
    $description = get_string('frontpage_courses_enable_desc', 'theme_worldcampus');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $name = 'theme_worldcampus/frontpage_courses_title';
    $title = get_string('frontpage_courses_title_setting', 'theme_worldcampus');
    $description = get_string('frontpage_courses_title_setting_desc', 'theme_worldcampus');
    $default = get_string('frontpage_courses_title_default', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_worldcampus/frontpage_courses_select_mode';
    $title = get_string('frontpage_courses_select_mode', 'theme_worldcampus');
    $description = get_string('frontpage_courses_select_mode_desc', 'theme_worldcampus');
    $default = 0;
    $choices = [
        0 => get_string('frontpage_courses_select_mode_all', 'theme_worldcampus'),
        1 => get_string('frontpage_courses_select_mode_newest', 'theme_worldcampus'),
        2 => get_string('frontpage_courses_select_mode_manual', 'theme_worldcampus'),
        3 => get_string('frontpage_courses_select_mode_category', 'theme_worldcampus'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $name = 'theme_worldcampus/frontpage_courses_selected';
    $title = get_string('frontpage_courses_selected', 'theme_worldcampus');
    $description = get_string('frontpage_courses_selected_desc', 'theme_worldcampus');
    $default = [];
    $setting = new admin_setting_configmultiselect($name, $title, $description, $default, $coursechoices);
    $page->add($setting);

    $name = 'theme_worldcampus/frontpage_courses_categories';
    $title = get_string('frontpage_courses_categories', 'theme_worldcampus');
    $description = get_string('frontpage_courses_categories_desc', 'theme_worldcampus');
    $default = [];
    $setting = new admin_setting_configmultiselect($name, $title, $description, $default, $categorychoices);
    $page->add($setting);

    $name = 'theme_worldcampus/frontpage_courses_preview_limit';
    $title = get_string('frontpage_courses_preview_limit', 'theme_worldcampus');
    $description = get_string('frontpage_courses_preview_limit_desc', 'theme_worldcampus');
    $default = 3;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $page->add($setting);

    $name = 'theme_worldcampus/frontpage_courses_per_page';
    $title = get_string('frontpage_courses_per_page', 'theme_worldcampus');
    $description = get_string('frontpage_courses_per_page_desc', 'theme_worldcampus');
    $default = 9;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $page->add($setting);

    $page->hide_if('theme_worldcampus/frontpage_courses_title', 'theme_worldcampus/frontpage_courses_enable', 'eq', 0);
    $page->hide_if('theme_worldcampus/frontpage_courses_select_mode', 'theme_worldcampus/frontpage_courses_enable', 'eq', 0);
    $page->hide_if('theme_worldcampus/frontpage_courses_selected', 'theme_worldcampus/frontpage_courses_enable', 'eq', 0);
    $page->hide_if('theme_worldcampus/frontpage_courses_categories', 'theme_worldcampus/frontpage_courses_enable', 'eq', 0);
    $page->hide_if('theme_worldcampus/frontpage_courses_preview_limit', 'theme_worldcampus/frontpage_courses_enable', 'eq', 0);
    $page->hide_if('theme_worldcampus/frontpage_courses_per_page', 'theme_worldcampus/frontpage_courses_enable', 'eq', 0);

    $page->hide_if('theme_worldcampus/frontpage_courses_selected', 'theme_worldcampus/frontpage_courses_select_mode', 'neq', 2);
    $page->hide_if('theme_worldcampus/frontpage_courses_categories', 'theme_worldcampus/frontpage_courses_select_mode', 'neq', 3);

    $setting = new admin_setting_heading('frontpagecoursesseparator', '', '<hr>');
    $page->add($setting);

    // Logged-in user custom content.
    $name = 'theme_worldcampus/frontpage_loggedin_content';
    $title = get_string('frontpage_loggedin_content', 'theme_worldcampus');
    $description = get_string('frontpage_loggedin_content_desc', 'theme_worldcampus');
    $setting = new admin_setting_configtextarea($name, $title, $description, '', PARAM_RAW);
    $page->add($setting);

    $setting = new admin_setting_heading('frontpageloggedinseparator', '', '<hr>');
    $page->add($setting);

    // Enable FAQ.
    $name = 'theme_worldcampus/faqcount';
    $title = get_string('faqcount', 'theme_worldcampus');
    $description = get_string('faqcountdesc', 'theme_worldcampus');
    $default = 0;
    $options = [];
    for ($i = 0; $i < 11; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $page->add($setting);

    $faqcount = get_config('theme_worldcampus', 'faqcount');

    if ($faqcount > 0) {
        for ($i = 1; $i <= $faqcount; $i++) {
            $name = "theme_worldcampus/faqquestion{$i}";
            $title = get_string('faqquestion', 'theme_worldcampus', $i . '');
            $setting = new admin_setting_configtext($name, $title, '', '');
            $page->add($setting);

            $name = "theme_worldcampus/faqanswer{$i}";
            $title = get_string('faqanswer', 'theme_worldcampus', $i . '');
            $setting = new admin_setting_confightmleditor($name, $title, '', '');
            $page->add($setting);
        }

        $setting = new admin_setting_heading('faqseparator', '', '<hr>');
        $page->add($setting);
    }

    $settings->add($page);

    /*
    * --------------------
    * Footer settings tab
    * --------------------
    */
    $page = new admin_settingpage('theme_worldcampus_footer', get_string('footersettings', 'theme_worldcampus'));

    $name = 'theme_worldcampus/footerlogo';
    $title = get_string('footerlogo', 'theme_worldcampus');
    $description = get_string('footerlogodesc', 'theme_worldcampus');
    $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo', 0, $opts);
    $page->add($setting);

    $name = 'theme_worldcampus/address';
    $title = get_string('address', 'theme_worldcampus');
    $description = get_string('addressdesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Website.
    $name = 'theme_worldcampus/website';
    $title = get_string('website', 'theme_worldcampus');
    $description = get_string('websitedesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Mobile.
    $name = 'theme_worldcampus/mobile';
    $title = get_string('mobile', 'theme_worldcampus');
    $description = get_string('mobiledesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Mail.
    $name = 'theme_worldcampus/mail';
    $title = get_string('mail', 'theme_worldcampus');
    $description = get_string('maildesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Facebook url setting.
    $name = 'theme_worldcampus/facebook';
    $title = get_string('facebook', 'theme_worldcampus');
    $description = get_string('facebookdesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Twitter url setting.
    $name = 'theme_worldcampus/twitter';
    $title = get_string('twitter', 'theme_worldcampus');
    $description = get_string('twitterdesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Linkdin url setting.
    $name = 'theme_worldcampus/linkedin';
    $title = get_string('linkedin', 'theme_worldcampus');
    $description = get_string('linkedindesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Youtube url setting.
    $name = 'theme_worldcampus/youtube';
    $title = get_string('youtube', 'theme_worldcampus');
    $description = get_string('youtubedesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Instagram url setting.
    $name = 'theme_worldcampus/instagram';
    $title = get_string('instagram', 'theme_worldcampus');
    $description = get_string('instagramdesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Whatsapp url setting.
    $name = 'theme_worldcampus/whatsapp';
    $title = get_string('whatsapp', 'theme_worldcampus');
    $description = get_string('whatsappdesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Telegram url setting.
    $name = 'theme_worldcampus/telegram';
    $title = get_string('telegram', 'theme_worldcampus');
    $description = get_string('telegramdesc', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    $settings->add($page);
}
