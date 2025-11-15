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

global $DB, $PAGE,  $OUTPUT;
$token = required_param('token', PARAM_RAW);
$PAGE->set_url(new moodle_url('/local/testimonial/submit.php', ['token' => $token]));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('submit_testimonial_title', 'local_testimonial'));
$PAGE->set_heading(get_string('submit_testimonial_title', 'local_testimonial'));

$tokenrecord = $DB->get_record('local_testimonial_tokens', ['token' => $token]);
if (!$tokenrecord || $tokenrecord->status != 0) {
    throw new moodle_exception('invalidtoken', 'local_testimonial');
}
$templatecontext = [
    'token' => $token
];
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_testimonial/submit', $templatecontext);
echo $OUTPUT->footer();