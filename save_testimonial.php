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

define('AJAX_SCRIPT', true);
require_once(dirname(__FILE__).'/../../config.php');

function send_json_error($message, $httpcode = 400) {
    http_response_code($httpcode);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}
global $DB;
$token = required_param('token', PARAM_RAW);
$tokenrecord = $DB->get_record('local_testimonial_tokens', ['token' => $token]);
if (!$tokenrecord || $tokenrecord->status != 0) {
    send_json_error(get_string('invalidtoken', 'local_testimonial'), 403);
}
$rawpostdata = file_get_contents('php://input');
$requestdata = json_decode($rawpostdata);
if (empty($requestdata) || !isset($requestdata->data) || !isset($requestdata->fname) || !isset($requestdata->type)) {
    send_json_error(get_string('invaliddata', 'local_testimonial'));
}
$fileData = $requestdata->data;
if (strpos($fileData, 'base64,') !== false) {
    $base64data = substr($fileData, strpos($fileData, ",") + 1);
    $decodedFileData = base64_decode($base64data);
    if ($decodedFileData === false) {
        send_json_error('Invalid Base64 data provided.');
    }
} else {
    $decodedFileData = $fileData;
}
$filename = clean_param($requestdata->fname, PARAM_FILE);
$filetype = clean_param($requestdata->type, PARAM_ALPHANUM);
$fs = get_file_storage();
$fileinfo = [
    'contextid'   => context_system::instance()->id,
    'component'   => 'local_testimonial',
    'filearea'    => 'testimonials',
    'itemid'      => $tokenrecord->contactid,
    'filepath'    => '/' . $filetype . '/',
    'filename'    => $filename,
    'userid'      => $tokenrecord->userid,
    'timecreated' => time(),
    'timemodified'=> time(),
];
try {
    $stored_file = $fs->create_file_from_string($fileinfo, $decodedFileData);
    if (!$stored_file) {
        send_json_error(get_string('couldnotsavefile', 'local_testimonial'), 500);
    }
    $record = new stdClass();
    $record->contactid = $tokenrecord->contactid;
    $record->timestamp = time();
    $record->testimonial_type = $filetype;
    $record->content_is_file = 1;
    $record->content_fileid = $stored_file->get_id();
    $newid = $DB->insert_record('local_testimonial', $record);
    if (!$newid) {
        $stored_file->delete();
        throw new dml_write_exception('DB insert_record failed to return a new ID for local_testimonial.');
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Testimonial saved successfully!', 'newid' => $newid]);
    exit();
} catch (Exception $e) {
    send_json_error('A database error occurred: ' . $e->getMessage(), 500);
}