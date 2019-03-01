<?php

if( ! defined('ABSPATH' ) ) exit;

/**
 * Add custom styles to WYSIWYG editor for clearer content editing
 */
function lj_custom_editor_styles( $mce_css ) {
	// add_editor_stylesheet
	$mce_css .= ', ' . plugins_url( '../assets/css/editor.css', __FILE__ );
	return $mce_css;
}
add_filter( 'mce_css', 'lj_custom_editor_styles' );