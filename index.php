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
require_once('filter_form.php');
require_login();

global $DB, $PAGE, $OUTPUT;
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/testimonial/index.php');
$PAGE->set_title(get_string('crm_customer_list_page', 'local_testimonial'));
$PAGE->set_heading(get_string('crm_customer_list_page', 'local_testimonial'));
require_capability('local/testimonial:view', context_system::instance());

$currenturl = new moodle_url('/local/testimonial/index.php');
$filterform = new local_testimonial_filter_form($currenturl);
$filterdata = $filterform->get_data();
$page = optional_param('page', 0, PARAM_INT);
$perpage = 10;
$crmBaseUrl = 'https://support.paktaleem.com';
$apiToken   = '';
function callPerfexApi($url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $headers = ['authtoken: ' . $token];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
$templateData = new stdClass();
$templateData->pageheading = get_string('crm_customer_list_page', 'local_testimonial');
$templateData->filterform = $filterform->render();
$customersUrl = $crmBaseUrl . '/api/customers';
$allCustomersData = callPerfexApi($customersUrl, $apiToken);
$processed_customers = [];
if (!empty($allCustomersData) && is_array($allCustomersData) && !isset($allCustomersData['error'])) {
    foreach ($allCustomersData as $customer) {
        $customerId = $customer['userid'];
        $primaryContactName = '...';
        $primaryContactEmail = '...';
        $contactsUrlForCustomer = $crmBaseUrl . '/api/contacts/' . $customerId;
        $contactsForThisCustomer = callPerfexApi($contactsUrlForCustomer, $apiToken);
        if (!empty($contactsForThisCustomer) && is_array($contactsForThisCustomer)) {
            foreach ($contactsForThisCustomer as $contact) {
                if (isset($contact['is_primary']) && $contact['is_primary'] == 1) {
                    $primaryContactName = $contact['firstname'] . ' ' . $contact['lastname'];
                    $primaryContactEmail = $contact['email'];
                    break;
                }
            }
        }        
        $processed_customers[] = (object) [
            'id' => $customerId,
            'company' => $customer['company'],
            'primarycontact' => $primaryContactName,
            'primaryemail' => $primaryContactEmail
        ];
    }
}
if (!empty($processed_customers)) {
    foreach ($processed_customers as $customer) {
        $customer->token_is_none = false;
        $customer->token_is_sent = false;
        $customer->token_is_used = false;
        $customer->token_is_expired = false;
        $latesttokens = $DB->get_records(
            'local_testimonial_tokens',
            ['contactid' => $customer->id],
            'id DESC', 'status', 0, 1
        );
        if ($latesttokens) {
            $latesttoken = array_shift($latesttokens);
            switch ($latesttoken->status) {
                case 0: $customer->token_is_sent = true; break;
                case 1: $customer->token_is_used = true; break;
                case 2: $customer->token_is_expired = true; break;
            }
        } else {
            $customer->token_is_none = true;
        }
    }
}
$filtered_customers = $processed_customers;
if ($filterdata && !empty(trim($filterdata->search))) {
    $searchquery = strtolower(trim($filterdata->search));
    $filtered_customers = array_filter($processed_customers, function($customer) use ($searchquery) {
        if (stripos(strtolower($customer->company), $searchquery) !== false) {
            return true;
        }
        if (stripos(strtolower($customer->primarycontact), $searchquery) !== false) {
            return true;
        }
        return false;
    });
}
$totalcount = count($filtered_customers);
if ($totalcount > 0) {
    $templateData->hascustomers = true;    
    $pageurl = new moodle_url('/local/testimonial/index.php', (array) $filterdata);
    $templateData->pagination = $OUTPUT->paging_bar($totalcount, $page, $perpage, $pageurl);
    $customersForThisPage = array_slice(array_values($filtered_customers), $page * $perpage, $perpage);
    $templateData->customers = $customersForThisPage;
} else {
    $templateData->hascustomers = false;
    $templateData->pagination = '';
    $templateData->notification_info = get_string('no_customers_found', 'local_testimonial');
}
echo $OUTPUT->header();
$filterform->set_data($filterdata);
$filterform->display();
echo $OUTPUT->render_from_template('local_testimonial/index', $templateData);
echo $OUTPUT->footer();