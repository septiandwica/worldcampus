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
 * World Campus theme custom core renderer extending Boost.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_worldcampus\output;

defined('MOODLE_INTERNAL') || die();

use theme_boost\output\core_renderer as boost_core_renderer;
use moodle_url;
use html_writer;
use custom_menu;

/**
 * World Campus core renderer extending Boost.
 */
class core_renderer extends boost_core_renderer {

    /**
     * Renders the custom page full header with breadcrumbs and title.
     *
     * @return string
     */
    public function full_header() {
        if ($this->page->include_region_main_settings_in_header_actions() &&
                !$this->page->blocks->is_block_present('settings')) {
            $this->page->add_header_action(html_writer::div(
                $this->render_from_template('core/region_main_settings_menu', $this->page->region_main_settings_menu()),
                'context-header-settings-menu'
            ));
        }

        $header = new \stdClass();
        $header->settingsmenu = $this->context_header_settings_menu();
        $header->contextheader = $this->context_header();
        $header->hasnavbar = empty($this->page->layout_options['nonavbar']);
        $header->navbar = $this->navbar();
        $header->pageheading = $this->page_heading();
        $header->pageheadingbutton = $this->page_heading_button();
        $header->headeractions = $this->page->get_header_actions();

        return $this->render_from_template('theme_worldcampus/core/full_header', $header);
    }

    /**
     * Custom styled Moodle login form renderer.
     *
     * @param \core_auth\output\login $form
     * @return string
     */
    public function render_login(\core_auth\output\login $form) {
        $context = $form->export_for_template($this);
        $context->sso_url = (new moodle_url('/auth/sso/login.php'))->out(false);
        return $this->render_from_template('theme_worldcampus/core/loginform', $context);
    }

    /**
     * Custom activity navigation in course modules (Previous / Next Activity).
     *
     * @return string
     */
    public function activity_navigation() {
        global $PAGE;
        if (!$PAGE->cm) {
            return '';
        }

        $course = $PAGE->course;
        $cm = $PAGE->cm;
        $modinfo = get_fast_modinfo($course);
        $section = $modinfo->get_section_info($cm->sectionnum);

        $prevcm = null;
        $nextcm = null;
        $foundcurrent = false;

        foreach ($section->sequence as $cmid) {
            if ($cmid == $cm->id) {
                $foundcurrent = true;
                continue;
            }
            if (!$foundcurrent) {
                $prevcm = $modinfo->get_cm($cmid);
            } else if ($nextcm === null) {
                $nextcm = $modinfo->get_cm($cmid);
                break;
            }
        }

        $context = [
            'has_prev' => !empty($prevcm) && $prevcm->uservisible,
            'prev_url' => $prevcm ? $prevcm->url->out(false) : '',
            'prev_name' => $prevcm ? format_string($prevcm->name) : '',
            'has_next' => !empty($nextcm) && $nextcm->uservisible,
            'next_url' => $nextcm ? $nextcm->url->out(false) : '',
            'next_name' => $nextcm ? format_string($nextcm->name) : '',
        ];

        return $this->render_from_template('theme_worldcampus/core_course/activity_navigation', $context);
    }
}
