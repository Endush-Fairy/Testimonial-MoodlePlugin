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

global $DB, $PAGE, $OUTPUT;
require_login();
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/local/testimonial/view_testimonials.php');
$PAGE->set_title(get_string('view_testimonials_title', 'local_testimonial'));
$PAGE->set_heading(get_string('view_testimonials_heading', 'local_testimonial'));
require_capability('local/testimonial:view', $context);

$testimonials = $DB->get_records('local_testimonial', [], 'timestamp DESC');
$template_data = [];
$fs = get_file_storage();
if (!empty($testimonials)) {
    foreach ($testimonials as $testimonial) {
        $data = new stdClass();
        $data->id = $testimonial->id;
        $data->timestamp = $testimonial->timestamp;
        $data->is_video = ($testimonial->testimonial_type === 'video');
        $data->is_text = ($testimonial->testimonial_type === 'text');
        $latesttokens = $DB->get_records(
            'local_testimonial_tokens',
            ['contactid' => $testimonial->contactid],
            'id DESC',
            '*',
            0,
            1
        );
        if (!empty($latesttokens)) {
            $latesttoken = array_shift($latesttokens);
            $data->clientemail = $latesttoken->email;
        } else {
            $data->clientemail = 'Unknown';
        }
        $file = $fs->get_file_by_id($testimonial->content_fileid);
        if (!$file) {
            continue;
        }
        if ($data->is_video) {
            $data->fileurl = moodle_url::make_pluginfile_url(
                $file->get_contextid(),
                'local_testimonial',
                'testimonials',
                $file->get_itemid(),
                $file->get_filepath(),
                $file->get_filename()
            );
        } else if ($data->is_text) {
            $data->content = $file->get_content();
        }
        $template_data[] = $data;
    }
}
$renderable_data = ['testimonials' => $template_data];
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_testimonial/view_testimonials', $renderable_data);
echo $OUTPUT->footer();