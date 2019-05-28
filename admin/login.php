<?php

if( ! defined('ABSPATH' ) ) exit;

/**
 * Remove shake effect on unsuccesful login attempts
 */
function lj_no_shakes_please() {
	remove_action( 'login_head', 'wp_shake_js', 12 );
}
add_action( 'login_head', 'lj_no_shakes_please' );

/**
 * Remove link to wordpress.org from login logo
 * @return str site home url
 */
function lj_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'lj_login_logo_url' );

/**
 * Remove reference to Wordpress from login logo title
 * @return str site's title
 */
function lj_login_logo_url_title() {
	return 'Return to ' . get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'lj_login_logo_url_title' );