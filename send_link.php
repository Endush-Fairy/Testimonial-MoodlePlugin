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

global $DB, $CFG, $USER, $PAGE;
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/testimonial/send_link.php');
require_capability('local/testimonial:view', context_system::instance());

$contactid = required_param('contactid', PARAM_INT);
$email = required_param('email', PARAM_EMAIL);
$customername = optional_param('name', 'Valued Client', PARAM_TEXT);
$tokenstring = random_string(40);
$record = new stdClass();
$record->token = $tokenstring;
$record->contactid = $contactid;
$record->email = $email;
$record->userid = $USER->id;
$record->timecreated = time();
$record->timeexpires = 0;
$record->timeused = 0;
$record->status = 0;
$DB->insert_record('local_testimonial_tokens', $record);
$testimonialurl = new moodle_url('/local/testimonial/submit.php', ['token' => $tokenstring]);
$subject = get_string('emailsubject', 'local_testimonial');
$email_params = new stdClass();
$email_params->clientname = $customername;
$email_params->link = $testimonialurl->out(false);
$htmlbody = get_string('emailbody', 'local_testimonial', $email_params);
$textbody = "Dear {$customername},\n\n";
$textbody .= "Please share your feedback by clicking the link below:\n";
$textbody .= $testimonialurl->out(false) . "\n\n";
$textbody .= "Regards,\nPakTaleem Team";
$recipient = new stdClass();
$recipient->id = -time();
$recipient->email = $email;
$recipient->firstname = $customername;
$recipient->lastname = ' ';
$recipient->username = $email;
$recipient->auth = 'manual';
$recipient->mailformat = 1;
$recipient->maildisplay = true;
$recipient->firstnamephonetic = '';
$recipient->lastnamephonetic = '';
$recipient->middlename = '';
$recipient->alternatename = '';
$success = email_to_user($recipient, $USER, $subject, $textbody, $htmlbody);
if ($success) {
    redirect(new moodle_url('/local/testimonial/index.php'), get_string('emailsent', 'local_testimonial'), 3);
} else {
    throw new moodle_exception('emailnotsent', 'local_testimonial');
}