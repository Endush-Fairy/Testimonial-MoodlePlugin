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

require_once('../../config.php');

global $DB, $PAGE;
$contactid = required_param('contactid', PARAM_INT);
$url = new moodle_url('/local/testimonial/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/testimonial/expire_link.php', ['contactid' => $contactid]);
require_capability('local/testimonial:view', context_system::instance());

$tokenrecords = $DB->get_records('local_testimonial_tokens', ['contactid' => $contactid, 'status' => 0]);
if ($tokenrecords) {
    foreach ($tokenrecords as $tokenrecord) {
        $tokenrecord->status = 2;
        $DB->update_record('local_testimonial_tokens', $tokenrecord);
    }
    redirect($url, get_string('linkexpiredsuccess', 'local_testimonial'), 3);
} else {
    redirect($url, get_string('linknotfound', 'local_testimonial'), 3);
}