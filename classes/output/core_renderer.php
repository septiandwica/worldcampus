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
 * Overridden theme boost core renderer for World Campus.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_worldcampus\output;

use theme_config;
use core\context\course as context_course;
use moodle_url;
use html_writer;
use coding_exception;
use theme_worldcampus\output\core_course\activity_navigation;

/**
 * Renderers to align Moodle's HTML with that expected by Boost and World Campus.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost\output\core_renderer {
    /**
     * The standard tags (meta tags, links to stylesheets and JavaScript, etc.)
     * that should be included in the <head> tag.
     *
     * @return string HTML fragment.
     */
    public function standard_head_html() {
        $output = parent::standard_head_html();

        $theme = theme_config::load('worldcampus');

        if (!empty($theme->settings->googleanalytics)) {
            $googleanalyticscode = "<script async src='https://www.googletagmanager.com/gtag/js?id=GOOGLE-ANALYTICS-CODE'></script>
                                    <script>
                                        window.dataLayer = window.dataLayer || [];
                                        function gtag() { dataLayer.push(arguments); }
                                        gtag('js', new Date());
                                        gtag('config', 'GOOGLE-ANALYTICS-CODE');
                                    </script>";
            $output .= str_replace("GOOGLE-ANALYTICS-CODE", trim($theme->settings->googleanalytics), $googleanalyticscode);
        }

        $sitefont = isset($theme->settings->fontsite) ? $theme->settings->fontsite : 'Moodle';
        if ($sitefont != 'Moodle') {
            $output .= '<link rel="preconnect" href="https://fonts.googleapis.com">
                       <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                       <link href="https://fonts.googleapis.com/css2?family=' . $sitefont . ':ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">';
        }

        return $output;
    }

    /**
     * Returns HTML attributes to use within the body tag.
     *
     * @param string|array $additionalclasses Any additional classes to give the body tag
     * @return string
     */
    public function body_attributes($additionalclasses = []) {
        $hasaccessibilitybar = get_user_preferences('themeworldcampussettings_enableaccessibilitytoolbar', '');
        if ($hasaccessibilitybar) {
            $additionalclasses[] = 'hasaccessibilitybar';

            $currentfontsizeclass = get_user_preferences('accessibilitystyles_fontsizeclass', '');
            if ($currentfontsizeclass) {
                $additionalclasses[] = $currentfontsizeclass;
            }

            $currentsitecolorclass = get_user_preferences('accessibilitystyles_sitecolorclass', '');
            if ($currentsitecolorclass) {
                $additionalclasses[] = $currentsitecolorclass;
            }
        }

        $fonttype = get_user_preferences('themeworldcampussettings_fonttype', '');
        if ($fonttype) {
            $additionalclasses[] = $fonttype;
        }

        if (!is_array($additionalclasses)) {
            $additionalclasses = explode(' ', $additionalclasses);
        }

        return ' id="'. $this->body_id().'" class="'.$this->body_css_classes($additionalclasses).'"';
    }

    /**
     * Whether we should display the main theme or site logo in the navbar.
     *
     * @return bool
     */
    public function should_display_logo() {
        if ($this->should_display_theme_logo() || parent::should_display_navbar_logo()) {
            return true;
        }

        return false;
    }

    /**
     * Whether we should display the main theme logo in the navbar.
     *
     * @return bool
     */
    public function should_display_theme_logo() {
        $logo = $this->get_theme_logo_url();
        return !empty($logo);
    }

    /**
     * Get the main logo URL.
     *
     * @return string
     */
    public function get_logo() {
        $logo = $this->get_theme_logo_url();
        if ($logo) {
            return $logo;
        }

        $logo = $this->get_logo_url();
        if ($logo) {
            return $logo->out(false);
        }

        return false;
    }

    /**
     * Get the theme logo URL.
     *
     * @return string
     */
    public function get_theme_logo_url() {
        $theme = theme_config::load('worldcampus');
        $logo = $theme->setting_file_url('logo', 'logo');
        if (!$logo) {
            return (new moodle_url('/theme/worldcampus/pix/logo.png'))->out();
        }
        return $logo;
    }

    /**
     * Renders the login form.
     *
     * @param \core_auth\output\login $form The renderable.
     * @return string
     */
    public function render_login(\core_auth\output\login $form) {
        global $SITE, $CFG;

        $context = $form->export_for_template($this);
        $context->errorformatted = $this->error_text($context->error);
        $context->logourl = $this->get_logo();
        
        $theme = theme_config::load('worldcampus');
        $logodark = $theme->setting_file_url('logodark', 'logodark');
        $context->logodark_url = $logodark ?: (new moodle_url('/theme/worldcampus/pix/logo-dark.png'))->out();
        $context->sso_url = (new moodle_url('/auth/sso/login.php'))->out(false);

        $context->sitename = format_string($SITE->fullname, true,
            ['context' => context_course::instance(SITEID), "escape" => false]);

        if (!$CFG->auth_instructions) {
            $context->instructions = null;
            $context->hasinstructions = false;
        }

        $context->hastwocolumns = false;
        if ($context->hasidentityproviders || $CFG->auth_instructions) {
            $context->hastwocolumns = true;
        }

        if ($context->identityproviders) {
            foreach ($context->identityproviders as $key => $provider) {
                $isfacebook = false;
                if (strpos($provider['iconurl'], 'facebook') !== false) {
                    $isfacebook = true;
                }
                $context->identityproviders[$key]['isfacebook'] = $isfacebook;
            }
        }

        return $this->render_from_template('core/loginform', $context);
    }

    /**
     * Returns the HTML for the site support email link
     *
     * @param array $customattribs
     * @param bool $embed
     * @return string
     */
    public function supportemail(array $customattribs = [], bool $embed = false): string {
        global $CFG;

        if (!isset($CFG->supportavailability) ||
            $CFG->supportavailability == CONTACT_SUPPORT_DISABLED ||
            ($CFG->supportavailability == CONTACT_SUPPORT_AUTHENTICATED && (!isloggedin() || isguestuser()))) {
            return '';
        }

        $label = get_string('contactsitesupport', 'admin');
        $icon = $this->pix_icon('t/life-ring', '', 'moodle', ['class' => 'iconhelp icon-pre']);
        $content = $icon . $label;

        if ($embed) {
            $content = $label;
        }

        if (!empty($CFG->supportpage)) {
            $attributes = ['href' => $CFG->supportpage, 'target' => 'blank', 'class' => 'btn contactsitesupport btn-outline-info'];
            $content .= $this->pix_icon('i/externallink', '', 'moodle', ['class' => 'ml-1']);
        } else {
            $attributes = [
                'href' => $CFG->wwwroot . '/user/contactsitesupport.php',
                'class' => 'btn contactsitesupport btn-outline-info',
            ];
        }

        $attributes += $customattribs;
        return html_writer::tag('a', $content, $attributes);
    }

    /**
     * Returns the moodle_url for the favicon.
     *
     * @return moodle_url
     */
    public function favicon() {
        global $CFG;
        $theme = theme_config::load('worldcampus');
        $favicon = $theme->setting_file_url('favicon', 'favicon');

        if (!empty($favicon)) {
            $urlreplace = preg_replace('|^https?://|i', '//', $CFG->wwwroot);
            $favicon = str_replace($urlreplace, '', $favicon);
            return new moodle_url($favicon);
        }

        return new moodle_url('/theme/worldcampus/pix/favicon.ico');
    }

    /**
     * Renders the header bar.
     *
     * @param \context_header $contextheader
     * @return string
     */
    protected function render_context_header(\context_header $contextheader) {
        if ($this->page->pagelayout == 'mypublic') {
            return '';
        }

        if (!isset($contextheader->heading)) {
            $heading = $this->heading($this->page->heading, $contextheader->headinglevel, 'h2');
        } else {
            $heading = $this->heading($contextheader->heading, $contextheader->headinglevel, 'h2');
        }

        $html = html_writer::start_div('page-context-header');

        if (isset($contextheader->imagedata)) {
            $html .= html_writer::div($contextheader->imagedata, 'page-header-image mr-2');
        }

        if (isset($contextheader->prefix)) {
            $prefix = html_writer::div($contextheader->prefix, 'text-muted text-uppercase small line-height-3');
            $heading = $prefix . $heading;
        }
        $html .= html_writer::tag('div', $heading, ['class' => 'page-header-headings']);

        if (isset($contextheader->additionalbuttons)) {
            $html .= html_writer::start_div('btn-group header-button-group');
            foreach ($contextheader->additionalbuttons as $button) {
                if (!isset($button->page)) {
                    if ($button['buttontype'] === 'togglecontact') {
                        \core_message\helper::togglecontact_requirejs();
                    }
                    if ($button['buttontype'] === 'message') {
                        \core_message\helper::messageuser_requirejs();
                    }
                    $image = $this->pix_icon($button['formattedimage'], $button['title'], 'moodle', [
                        'class' => 'iconsmall',
                        'role' => 'presentation',
                    ]);
                    $image .= html_writer::span($button['title'], 'header-button-title');
                } else {
                    $image = html_writer::empty_tag('img', [
                        'src' => $button['formattedimage'],
                        'role' => 'presentation',
                    ]);
                }
                $html .= html_writer::link($button['url'], html_writer::tag('span', $image), $button['linkattributes']);
            }
            $html .= html_writer::end_div();
        }
        $html .= html_writer::end_div();

        return $html;
    }

    /**
     * Full page header with breadcrumb and actions.
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
     * Standard navigation between activities in a course.
     *
     * @return string
     */
    public function activity_navigation() {
        $context = $this->page->context;
        if (($this->page->pagelayout !== 'incourse' && $this->page->pagelayout !== 'frametop')
            || $context->contextlevel != CONTEXT_MODULE) {
            return '';
        }

        if ($this->page->cm->is_stealth()) {
            return '';
        }

        $course = $this->page->cm->get_course();
        $modules = get_fast_modinfo($course->id)->get_cms();

        $mods = [];
        $activitylist = [];
        foreach ($modules as $module) {
            if (!$module->uservisible || $module->is_stealth() || empty($module->url)) {
                continue;
            }
            $mods[$module->id] = $module;

            if ($module->id == $this->page->cm->id) {
                continue;
            }
            $modname = $module->get_formatted_name();
            if (!$module->visible) {
                $modname .= ' ' . get_string('hiddenwithbrackets');
            }
            $linkurl = new moodle_url($module->url, ['forceview' => 1]);
            $activitylist[$linkurl->out(false)] = $modname;
        }

        $nummods = count($mods);
        if ($nummods == 1) {
            return '';
        }

        $modids = array_keys($mods);
        $position = array_search($this->page->cm->id, $modids);

        $prevmod = null;
        $nextmod = null;

        if ($position > 0) {
            $prevmod = $mods[$modids[$position - 1]];
        }
        if ($position < ($nummods - 1)) {
            $nextmod = $mods[$modids[$position + 1]];
        }

        $activitynav = new activity_navigation($prevmod, $nextmod, $activitylist);
        $renderer = $this->page->get_renderer('core', 'course');
        return $renderer->render($activitynav);
    }

    /**
     * Redirects the user with a modern loading overlay.
     */
    public function redirect_message($encodedurl, $message, $delay, $debugdisableredirect,
                                     $messagetype = \core\output\notification::NOTIFY_INFO) {
        $url = str_replace('&amp;', '&', $encodedurl);

        switch ($this->page->state) {
            case \moodle_page::STATE_BEFORE_HEADER :
                if (!$debugdisableredirect) {
                    $this->metarefreshtag = '<meta http-equiv="refresh" content="'. $delay .'; url='. $encodedurl .'" />'."\n";
                    $this->page->requires->js_function_call('document.location.replace', [$url], false, ($delay + 3));
                }
                $output = $this->header();
                break;
            case \moodle_page::STATE_PRINTING_HEADER :
                throw new coding_exception('You cannot redirect while printing the page header');
                break;
            case \moodle_page::STATE_IN_BODY :
                debugging("You should really redirect before you start page output");
                if (!$debugdisableredirect) {
                    $this->page->requires->js_function_call('document.location.replace', [$url], false, $delay);
                }
                $output = $this->opencontainers->pop_all_but_last();
                break;
            case \moodle_page::STATE_DONE :
                throw new coding_exception('You cannot redirect after the entire page has been generated');
                break;
        }

        $output .= $this->notification($message, $messagetype);
        $output .= $this->render_from_template('theme_worldcampus/loading-overlay', ['encodedurl' => $encodedurl]);

        if ($debugdisableredirect) {
            $output .= '<p><strong>'.get_string('erroroutput', 'error').'</strong></p>';
        }

        $output .= $this->footer();
        return $output;
    }

    /**
     * Renders breadcrumb navbar.
     *
     * @return string
     */
    public function navbar(): string {
        $newnav = new \theme_worldcampus\output\boostnavbar($this->page);
        return $this->render_from_template('core/navbar', $newnav);
    }

    /**
     * Whether we should display footer logo.
     *
     * @return bool
     */
    public function should_display_footer_logo() {
        $footer_logo = $this->get_footer_logo_url();
        return !empty($footer_logo);
    }

    /**
     * Get the main footer logo URL.
     *
     * @return string
     */
    public function get_footer_logo() {
        $footer_logo = $this->get_footer_logo_url();
        if ($footer_logo) {
            return $footer_logo;
        }
        return false;
    }

    /**
     * Get the footer logo URL.
     *
     * @return string
     */
    public function get_footer_logo_url() {
        $theme = theme_config::load('worldcampus');
        $footerlogo = $theme->setting_file_url('footerlogo', 'footerlogo');
        if (!$footerlogo) {
            return (new moodle_url('/theme/worldcampus/pix/footer-logo.png'))->out();
        }
        return $footerlogo;
    }
}
