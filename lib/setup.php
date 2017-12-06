<?php

/**
 * Disable fucking emojis
 * We love emojis, just not on a website (and by default)
 */
function lbrjk_disable_emoji() {
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	// Remove emojis from TinyMCE
	// add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce')
}
add_action('after_setup_theme', 'lbrjk_disable_emoji');

/**
 * Disable REST API
 * Not needed for the majority of sites with basic functionality
 * Remove if required *
 */
// Filters for WP-API version 1.x
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');
// Filters for WP-API version 2.x
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');
// Prevent output in head
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);