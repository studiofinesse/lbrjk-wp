<?php

/**
 * Set default options when inserting media
 */
function lj_media_config() {
	update_option('image_default_align', 'none' ); // No alignment
	update_option('image_default_link_type', 'none' ); // No link
	update_option('image_default_size', 'large' ); // Full size

	// Update default image sizes to something more usable
	update_option('thumbnail_size_w', 300); // thumbnail width
	update_option('thumbnail_size_h', 300); // thumbnail height
	update_option('medium_size_w', 800); // medium width
	update_option('medium_size_h', 9999); // medium height
	update_option('large_size_w', 1500); // large width
	update_option('large_size_h', 9999); // large height

}
add_action('after_setup_theme', 'lj_media_config');

/**
 * Wrap images in div with class for styling
 * rather than default p tag
 * @param  str $content The original content of the post
 * @return str          The updated content with replacements made
 */
function lj_image_wrap($content){
	return preg_replace(
		'/(?:<p[^>]*>)?<img .*?class=["\'](.*?)" .*?src=["\'](.*?)" .*?alt=["\'](.*?)"["\' ][^>]*>(?:<\/p>)?/',
		'<div class="post-image $1"><img src="$2" alt="$3" /></div>',
		$content
	);
}
add_filter('the_content', 'lj_image_wrap');

/**
 * Removes the inline style width declaration from the wp-caption element
 * Also updates the class to a less wp specific 'post-caption'
 * @param  array $attr    The image attributes
 * @return string         The html of the caption
 */
function lj_caption_fix($attr, $content = null) {
	if (!isset($attr['caption'])) {
		if(preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches)) {
			$content = $matches[1];
			$attr['caption'] = trim($matches[2]);
		}
	}

	$output = apply_filters('img_caption_shortcode', '', $attr, $content);

	if ($output != '')
		return $output;
	extract(shortcode_atts(array(
		'id'    => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	), $attr));

	if (1 > (int) $width || empty($caption))
		return $content;

	if($id) $id = 'id="' . esc_attr($id) . '" ';
	return '<figure ' . $id . 'class="post-caption">'
	. do_shortcode( $content ) . '<figcaption class="post-caption-text">' . $caption . '</figcaption></figure>';
}
add_shortcode('wp_caption', 'lj_caption_fix');
add_shortcode('caption', 'lj_caption_fix');