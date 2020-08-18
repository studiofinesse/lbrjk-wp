<?php

if ( ! defined( 'ABSPATH') ) exit;

/**
 * Output copyright symbol and current year
 * @return str e.g. '© 2017'
 */
function sc_copyright_message( $atts ) {

	$current_year = date( 'Y' );

	extract( shortcode_atts( array(
		'start' => $current_year,
		'append' => ''

	), $atts ) );

	if( $start == $current_year ) {
		$years = $current_year;
	} else {
		$years = "$start-$current_year";
	}

	if( $append )
		return "&copy $append $years";
	else {
		return "&copy $years";
	}

}
add_shortcode( 'copyright', 'sc_copyright_message' );

function sc_company_tel() {
	return get_company_info( 'tel' );
}
add_shortcode( 'company_tel', 'sc_company_tel' );

function sc_company_tel_link() {
	return the_company_tel_link();
}
add_shortcode( 'company_tel_link', 'sc_company_tel_link' );

function sc_company_email_link() {
	return the_company_email( false, true );
}
add_shortcode( 'company_email_link', 'sc_company_email_link' );
