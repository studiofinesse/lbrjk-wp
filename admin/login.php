<?php

/**
 * Output custom stylesheet to head of login page
 * @return str html link to stylesheet
 */
function lbrjk_custom_login() {
	$files = '<link rel="stylesheet" href="' . LBRJK_URL . '/assets/css/login.css" />';
	// Echo link to custom stylesheet
	echo $files;
}
add_action( 'login_head', 'lbrjk_custom_login' );

/**
 * Remove shake effect on unsuccesful login attempts
 */
function no_shakes_please() {
	remove_action( 'login_head', 'wp_shake_js', 12 );
}
add_action( 'login_head', 'no_shakes_please' );

/**
 * Remove link to wordpress.org from login logo
 * @return str site home url
 */
function lbrjk_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'lbrjk_login_logo_url' );

/**
 * Remove reference to Wordpress from login logo title
 * @return str site's title
 */
function lbrjk_login_logo_url_title() {
	return 'Return to ' . get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'lbrjk_login_logo_url_title' );