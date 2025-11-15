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

$string['pluginname'] = 'Testimonial';
$string['submit_testimonial'] = 'Submit Your Testimonial';
$string['provide_feedback'] = 'Provide Your Feedback';
$string['greeting'] = 'Hi,';
$string['intro'] = "We hope you've had an amazing experience with our services! Your satisfaction means the world to us, and we'd love to hear about your journey.";
$string['invite'] = "We value your experience with us. Please click the link below to submit your testimonial and help us continue delivering exceptional service to our community.";
$string['buttontext'] = 'Submit Your Testimonial';
$string['footerthanks'] = 'Thank you for being part of our journey!';
$string['regards'] = 'Regards,';
$string['companyname'] = 'PakTaleem';
$string['submittestimonial'] = '📩 Submit Testimonial';
$string['writetestimonial'] = 'Write your testimonial';
$string['uploadvideo'] = 'Upload a video testimonial';
$string['shareexperience'] = 'Share Your Experience';
$string['thankyoufeedback'] = 'Thank you for your feedback!';
$string['invalidtoken'] = 'Invalid or expired token.';
$string['submit'] = 'Submit';
$string['cancelled'] = 'Cancelled';
$string['missingtoken'] = 'Access token is missing. Please use the correct link from your email.';
$string['crm_customer_list_page'] = 'Client Management';
$string['crm_customer_list_desc'] = 'View the list of all customers from the CRM.';
$string['no_customers_found'] = 'No customer data could be retrieved from the CRM.';
$string['primarycontact'] = 'Client Name';
$string['companyname'] = 'Company Name';
$string['searchbyname'] = 'Search by name/company';
$string['filter'] = 'Filter';
$string['sendlink'] = 'Send Link';
$string['emailsubject'] = 'Your feedback is important to us!';
$string['emailbody'] = '<p> Hi {$a->clientname},<br>
May you live in peace!<br>
I hope you\'re having wonderful days and truly enjoying life at its best.<br>
<b>Congratulations</b>, your project is now complete!<br>
It\'s been a genuine pleasure working with you. Thank you for your trust, patience, and the smooth collaboration throughout. This project has been a great experience for the PakTaleem team, and we sincerely hope you\'ve been equally pleased with both the process and the results. Please share your feedback by clicking the link below:<br>
    <a href="{$a->link}" style="
        display: inline-block;
        padding: 15px 30px;
        background-color: #d5ebe6;
        color: #1bb59a;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;">
        Submit Your Testimonial
    </a>
<br>
Thank you once again for choosing PakTaleem. We truly hope this is just the beginning of a long and meaningful partnership.<br>
Warm regards,<br>
PakTaleem Team
</p>';
$string['emailsent'] = 'A testimonial link has been successfully sent to the client.';
$string['emailnotsent'] = 'Error: The email could not be sent.';
$string['submit_testimonial_title'] = 'Submit Your Testimonial';
$string['invalidtoken'] = 'The link you used is invalid. Please request a new one.';
$string['tokenused'] = 'This feedback link has already been used.';
$string['tokenexpired'] = 'This feedback link has expired.';
$string['expirelink'] = 'Expire Link';
$string['linksent'] = 'Link Sent (Active)';
$string['linkexpired'] = 'Link Expired';
$string['linkused'] = 'Testimonial Received';
$string['linkexpiredsuccess'] = 'The testimonial link has been successfully expired.';
$string['linknotfound'] = 'Testimonial link not found or is already inactive.';
$string['viewtestimonials'] = 'View Submitted Testimonials';
$string['view_testimonials_title'] = 'Submitted Testimonials';
$string['view_testimonials_heading'] = 'Submitted Testimonials';
$string['clientemail'] = 'Client Email';
$string['testimonialtype'] = 'Type';
$string['submissiondate'] = 'Submission Date';
$string['testimonialcontent'] = 'Testimonial';
$string['notestimonials'] = 'No testimonials have been submitted yet.';
$string['videotestimonial'] = 'Video';
$string['texttestimonial'] = 'Text';
$string['invaliddata'] = 'Invalid data submission. Required information is missing.';
$string['couldnotsavefile'] = 'Could not save the testimonial file. Please contact the administrator.';
$string['dberror'] = 'A database error occurred. Could not save the testimonial record.';
$string['testimonial:submit'] = 'Submit a testimonial';
$string['testimonial:view'] = 'View submitted testimonials';
$string['testimonial:submittestimonial'] = 'Submit testimonial via link';
$string['opinion'] = 'Your feedback helps us improve and helps others make informed decisions. We value your honest opinion.';
$string['leave'] = 'Leave a Testimonial';
$string['choose'] = 'Choose how you\'d like to share your feedback.';
$string['video'] = '🎥 Video Testimonial';
$string['text'] = '📝 Text Testimonial';
$string['record'] = 'Record Your Video Testimonial';
$string['recording'] = '🔴 Start Recording';
$string['stop'] = '⏹️ Stop Recording';
$string['cancel'] = 'Cancel';
$string['preview'] = 'Preview Your Testimonial';
$string['save'] = '💾 Save Testimonial';
$string['retake'] = '🔄 Retake Video';
$string['thankyoutext'] = 'We have received your submission. Thank you for sharing your experience!';