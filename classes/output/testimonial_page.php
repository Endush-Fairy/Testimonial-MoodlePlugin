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
namespace local_testimonial\output;

use renderable;
use templatable;
use renderer_base;

class testimonial_page implements renderable, templatable {
    protected $submiturl;
    public function __construct($submiturl) {
        $this->submiturl = $submiturl;
    }
    public function export_for_template(renderer_base $output) {
        return [
            'greeting' => get_string('greeting', 'local_testimonial'),
            'intro' => get_string('intro', 'local_testimonial'),
            'invite' => get_string('invite', 'local_testimonial'),
            'buttontext' => get_string('buttontext', 'local_testimonial'),
            'footerthanks' => get_string('footerthanks', 'local_testimonial'),
            'regards' => get_string('regards', 'local_testimonial'),
            'companyname' => get_string('companyname', 'local_testimonial'),
            'submiturl' => $this->submiturl,
        ];
    }
}
