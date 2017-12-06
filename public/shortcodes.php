<?php

/**
 * Output copyright symbol and current year
 * @return str e.g. '© 2017'
 */
function sc_copyright_message() {
	$year = date('Y');
	return ' &copy; Copyright ' . $year;
}
add_shortcode('copyright', 'sc_copyright_message');

function sc_company_tel() {
	return get_company_info('tel');
}
add_shortcode('company_tel', 'sc_company_tel');

function sc_company_tel_link() {
	return the_company_tel_link();
}
add_shortcode('company_tel_link', 'sc_company_tel_link');

function sc_company_email_link() {
	return the_company_email_link();
}
add_shortcode('company_email_link', 'sc_company_email_link');