<?php

/**
 * Simply output results of var_dump function
 * inside preformatted tags for easy reading
 * @param  mixed $data Data to explore
 * @return str       Result of data inside <pre> tags
 */
function dump($data) {
	echo '<pre>' , var_dump($data) , '</pre>';
}

/**
 * Update the blog description with custom field
 * Also reduce chance of 'Just another WordPress' site being displayed
 * @param  str $text   The current text
 * @param  mixed $show The type of information requested
 * @return str         New description
 */
function update_blog_description($text, $show) {
	$tagline = get_company_info('tagline');

    if ('description' == $show) {
        if($tagline) {
			$text = $tagline;
		} else {
			if($text != 'Just another WordPress site') {
				$text = $text;
			} else {
				$text = '';
			}
		}
    }
    return $text;
}
add_filter('bloginfo', 'update_blog_description', 10, 2);

/**
 * List the terms of a post from a specific taxonomy
 * @param  integer $id  The ID of the post
 * @param  string  $tax Name of the taxonomy to grab the terms of
 */
function list_terms($id = 0, $tax = '') {
	$terms_as_text = get_the_term_list($id, $tax, '', ', ');
	if(!empty($terms_as_text)) echo strip_tags($terms_as_text);
}

/**
 * Retrieve the posts image as a url
 * @param  string $size Name of the thumbnail size to return
 * @return string       URL of image in requested size
 */
function get_post_img_url( $size = 'full', $post_id = 0 ) {
	global $post;

	$id = isset( $post_id ) ? $post_id : $post->ID;

	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
	$url = $thumb['0'];

	return $url;
}

/**
 * Create custom post type labels
 * @param  str $singular Singular name
 * @param  str $plural   Plural name, leave blank to append 's' to singular
 * @return array         Full list of required labels
 */
function post_type_labels($singular, $plural = null) {

	if ($plural === null) {
		$plural = $singular . 's';
	}

	$labels = array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'menu_name'          => $plural,
		'name_admin_bar'     => $singular,
		'add_new'            => 'Add New '.$singular,
		'add_new_item'       => 'Add New '.$singular,
		'new_item'           => 'New '.$singular,
		'edit_item'          => 'Edit '.$singular,
		'view_item'          => 'View '.$singular,
		'all_items'          => 'All '.$plural,
		'search_items'       => 'Search '.$plural,
		'parent_item_colon'  => 'Parent '.$plural.': ',
		'not_found'          => 'No '.$plural.' found.',
		'not_found_in_trash' => 'No '.$plural.' found in Trash.'
	);

	return $labels;
}

/**
 * Determine whether a hex color is light.
 *
 * @param mixed  $color Color.
 * @return bool  True if a light color.
 */
function lbrjk_hex_is_light( $color ) {
    $hex = str_replace( '#', '', $color );

    $c_r = hexdec( substr( $hex, 0, 2 ) );
    $c_g = hexdec( substr( $hex, 2, 2 ) );
    $c_b = hexdec( substr( $hex, 4, 2 ) );

    $brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

    return $brightness > 155;
}