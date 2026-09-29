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
 * World Campus theme configuration extending Boost with React 19 + Shadcn UI + Tailwind CSS.
 *
 * @package   theme_worldcampus
 * @copyright 2026 Septian Dwi Cahyo (@septian.dwica)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/lib.php');

$THEME->name = 'worldcampus';

// Extend from Boost for 100% core Moodle stability
$THEME->parents = ['boost'];

// Sheets & SCSS
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->usefallback = false;

// Renderer factory
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;
$THEME->haseditswitch = true;
$THEME->usescourseindex = true;

// Layout definitions
$THEME->layouts = [
    // Base layout
    'base' => [
        'file' => 'drawers.php',
        'regions' => [],
    ],
    // Standard layout with sidebar blocks
    'standard' => [
        'file' => 'drawers.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // Course main view
    'course' => [
        'file' => 'course.php',
        'regions' => ['side-pre', 'content'],
        'defaultregion' => 'side-pre',
        'options' => ['langmenu' => true],
    ],
    // Course category listing
    'coursecategory' => [
        'file' => 'drawers.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // In-course activity view (Quiz, Assignment, Lesson, Resource)
    'incourse' => [
        'file' => 'incourse.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // Frontpage / Landing page (World Campus showcase)
    'frontpage' => [
        'file' => 'frontpage.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
        'options' => ['nonavbar' => false],
    ],
    // User Dashboard (My Moodle / Dashboard)
    'mydashboard' => [
        'file' => 'dashboard.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
        'options' => ['nonavbar' => false, 'langmenu' => true],
    ],
    // My Courses Catalog
    'mycourses' => [
        'file' => 'mycourses.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // Site administration & settings
    'admin' => [
        'file' => 'drawers.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // User profile & preferences
    'settings' => [
        'file' => 'drawers.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    // Authentication / Login page
    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'options' => ['langmenu' => true, 'nonavbar' => true, 'nofooter' => true],
    ],
    // Maintenance page
    'maintenance' => [
        'file' => 'maintenance.php',
        'regions' => [],
        'options' => ['noblocks' => true, 'nonavbar' => true],
    ],
    // Popup and embedded
    'popup' => [
        'file' => 'embedded.php',
        'regions' => [],
        'options' => ['nofooter' => true, 'nonavbar' => true],
    ],
    'embedded' => [
        'file' => 'embedded.php',
        'regions' => [],
        'options' => ['nofooter' => true, 'nonavbar' => true],
    ],
    'redirect' => [
        'file' => 'embedded.php',
        'regions' => [],
    ],
    'report' => [
        'file' => 'drawers.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'secure' => [
        'file' => 'secure.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
];
