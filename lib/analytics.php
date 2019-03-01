<?php

if( ! defined('ABSPATH' ) ) exit;

/**
 * Output Google Analytics tracking code
 * Inputted by user in site options
 * @return str Tracking code
 */
function lj_insert_ga_tracking_code() {

	$current_user_role = lj_get_user_role(); // get current user role
	$allowed_user_roles = get_field( 'google_analytics', 'option' )['google_analytics_allowed_roles']; // Retrieve allowed user roles from option
	$tracking_code = get_field( 'google_analytics', 'option' )['google_analytics_tracking_code']; // Store the tracking code from option

	if( $tracking_code && in_array( $current_user_role, $allowed_user_roles ) ) {
		echo '<!-- Start Analytics -->';
		echo $tracking_code;
		echo '<!-- / End Analytics -->';
	}

}

add_action( 'wp_head', 'lj_insert_ga_tracking_code' );