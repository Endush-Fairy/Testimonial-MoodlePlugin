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
 *Code for Testimonial plugin.
 *
 * @package    local_testimonial
 * @copyright  2025 Endush Fairy <endush.fairy@paktaleem.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Serves the files from the local_testimonial file areas.
 * This function only run when file is shown to Moodle.
 *
 * @param stdClass $course The course object
 * @param stdClass $cm The course module object
 * @param stdClass $context The context
 * @param string $filearea The file area
 * @param array $args The remaining arguments
 * @param bool $forcedownload Whether to force download
 * @param array $options Additional options
 * @return bool
 */
function local_testimonial_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;
        if ($filearea !== 'testimonials' ) {
            return false;
        }
    if (!has_capability('local/testimonial:view', $context)) {
        return false;
    }
    if ($filearea === 'testimonials') {
    }
    $itemid = array_shift($args);
    $filename = array_pop($args);
    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/' . implode('/', $args) . '/';
    }
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_testimonial', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        send_file_not_found();
    }
    send_stored_file($file, 0, 0, $forcedownload, $options);
}