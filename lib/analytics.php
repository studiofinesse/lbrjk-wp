<?php

/**
 * Output Google Analytics tracking code
 * Inputted by user in site options
 * @return str Tracking code
 */
function ga_tracking_code() {
	$current_user_role = get_user_role();
	$allowed_user_roles = get_field('google_analytics', 'option')['google_analytics_allowed_roles'];
	$tracking_code = get_field('google_analytics', 'option')['google_analytics_tracking_code'];

	if($tracking_code && in_array($current_user_role, $allowed_user_roles)) {
		echo '<!-- Google Analytics -->';
		echo $tracking_code;
	}
}
add_action('wp_head', 'ga_tracking_code');