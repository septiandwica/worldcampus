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
 * World Campus theme settings.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingworldcampus', get_string('configtitle', 'theme_worldcampus'));

    // TAB 1: General & Branding
    $page = new admin_settingpage('theme_worldcampus_general', get_string('generalheadingsub', 'theme_worldcampus'));

    // Logo
    $name = 'theme_worldcampus/logo';
    $title = get_string('logourl', 'theme_worldcampus');
    $description = get_string('logourl_desc', 'theme_worldcampus');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Tagline
    $name = 'theme_worldcampus/tagline';
    $title = get_string('tagline', 'theme_worldcampus');
    $description = '';
    $default = 'Connecting You to Global Education';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $page->add($setting);

    $settings->add($page);

    // TAB 2: Frontpage & Hero Showcase
    $page = new admin_settingpage('theme_worldcampus_frontpage', get_string('frontpageheading', 'theme_worldcampus'));

    // Hero Title
    $name = 'theme_worldcampus/herotitle';
    $title = get_string('herotitle', 'theme_worldcampus');
    $description = '';
    $default = get_string('herotitle_default', 'theme_worldcampus');
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $page->add($setting);

    // Hero Subtitle
    $name = 'theme_worldcampus/herosubtitle';
    $title = get_string('herosubtitle', 'theme_worldcampus');
    $description = '';
    $default = get_string('herosubtitle_default', 'theme_worldcampus');
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $page->add($setting);

    // Hero CTA Button Text
    $name = 'theme_worldcampus/herobuttontext';
    $title = get_string('herobuttontext', 'theme_worldcampus');
    $description = '';
    $default = 'Explore Global Courses';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $page->add($setting);

    // Hero CTA Button URL
    $name = 'theme_worldcampus/herobuttonurl';
    $title = get_string('herobuttonurl', 'theme_worldcampus');
    $description = '';
    $default = '/course/index.php';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $page->add($setting);

    $settings->add($page);
}
