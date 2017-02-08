<?php

/**
 * Add custom styles to WYSIWYG editor for clearer content editing
 */
function lbrjk_custom_editor_styles($mce_css) {
	// add_editor_stylesheet
	$mce_css .= ', ' . plugins_url('css/lbrjk-editor.css', __FILE__);
	return $mce_css;
}
add_filter('mce_css', 'lbrjk_custom_editor_styles');

/**
 * Reveal the hidden "Styles" dropdown in the advanced toolbar
 */
function editor_buttons($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'editor_buttons');

/**
 * Add custom style formats/classes to dropdown
 * e.g. Lead paragraphs and buttons
 */
function lbrjk_mce_styles($settings) {

	$style_formats = array(
		array(
			'title' => 'Lead',
			'selector' => 'p',
			'classes' => 'lead'
		),
		array(
			'title' => 'Small Button',
			'selector' => 'a',
			'classes' => 'button--small'
		),
		array(
			'title' => 'Large Button',
			'selector' => 'a',
			'classes' => 'button--large'
		),
		array(
			'title' => 'Button Primary',
			'selector' => 'a',
			'classes' => 'button--primary'
		),
		array(
			'title' => 'Button Secondary',
			'selector' => 'a',
			'classes' => 'button--secondary'
		),
		array(
			'title' => 'Button Alt',
			'selector' => 'a',
			'classes' => 'button--alt'
		),
		array(
			'title' => 'Button Ghost',
			'selector' => 'a',
			'classes' => 'button--ghost'
		)
	);

	$settings['style_formats'] = json_encode($style_formats);

	return $settings;
}
add_filter('tiny_mce_before_init', 'lbrjk_mce_styles');