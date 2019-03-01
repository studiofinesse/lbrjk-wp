<?php

if( ! defined('ABSPATH' ) ) exit;

/**
 * Simply output results of var_dump function
 * inside preformatted tags for easy reading
 * @param  mixed $data Data to explore
 * @return str       Result of data inside <pre> tags
 */
function dump( $data ) {
	echo '<pre>' , var_dump( $data ) , '</pre>';
}

function lj_get_posthumbnail( $post = 0 ) {
	$attachment = get_post_thumbnail_id( $post );

	// get post
	if( !$attachment = get_post($attachment) ) {
		return false;
	}

	// validate post_type
	if( $attachment->post_type !== 'attachment' ) {
		return false;
	}

	// vars
	$sizes_id = 0;
	$meta = wp_get_attachment_metadata( $attachment->ID );
	$attached_file = get_attached_file( $attachment->ID );
	$attachment_url = wp_get_attachment_url( $attachment->ID );

	// get mime types
	if( strpos( $attachment->post_mime_type, '/' ) !== false ) {
		list( $type, $subtype ) = explode( '/', $attachment->post_mime_type );
	} else {
		list( $type, $subtype ) = array( $attachment->post_mime_type, '' );
	}

	// vars
	$response = array(
		'ID'			=> $attachment->ID,
		'id'			=> $attachment->ID,
		'title'       	=> $attachment->post_title,
		'filename'		=> wp_basename( $attached_file ),
		'filesize'		=> 0,
		'url'			=> $attachment_url,
		'link'			=> get_attachment_link( $attachment->ID ),
		'alt'			=> get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'author'		=> $attachment->post_author,
		'description'	=> $attachment->post_content,
		'caption'		=> $attachment->post_excerpt,
		'name'			=> $attachment->post_name,
        'status'		=> $attachment->post_status,
        'uploaded_to'	=> $attachment->post_parent,
        'date'			=> $attachment->post_date_gmt,
		'modified'		=> $attachment->post_modified_gmt,
		'menu_order'	=> $attachment->menu_order,
		'mime_type'		=> $attachment->post_mime_type,
        'type'			=> $type,
        'subtype'		=> $subtype,
        'icon'			=> wp_mime_type_icon( $attachment->ID )
	);

	// filesize
	if( isset($meta['filesize']) ) {
		$response['filesize'] = $meta['filesize'];
	} elseif( file_exists($attached_file) ) {
		$response['filesize'] = filesize( $attached_file );
	}

	// image
	if( $type === 'image' ) {

		$sizes_id = $attachment->ID;
		$src = wp_get_attachment_image_src( $attachment->ID, 'full' );

		$response['url'] = $src[0];
		$response['width'] = $src[1];
		$response['height'] = $src[2];

	// video
	} elseif( $type === 'video' ) {

		// dimentions
		$response['width'] = acf_maybe_get($meta, 'width', 0);
		$response['height'] = acf_maybe_get($meta, 'height', 0);

		// featured image
		if( $featured_id = get_post_thumbnail_id($attachment->ID) ) {
			$sizes_id = $featured_id;
		}

	// audio
	} elseif( $type === 'audio' ) {

		// featured image
		if( $featured_id = get_post_thumbnail_id($attachment->ID) ) {
			$sizes_id = $featured_id;
		}
	}


	// sizes
	if( $sizes_id ) {

		// vars
		$sizes = get_intermediate_image_sizes();
		$data = array();

		// loop
		foreach( $sizes as $size ) {
			$src = wp_get_attachment_image_src( $sizes_id, $size );
			$data[ $size ] = $src[0];
			$data[ $size . '-width' ] = $src[1];
			$data[ $size . '-height' ] = $src[2];
		}

		// append
		$response['sizes'] = $data;
	}

	// return
	return $response;

}

/**
 * Retrieve the posts image as a url
 * @param  string $size Name of the thumbnail size to return
 * @return string       URL of image in requested size
 */
function get_post_thumbnail_url( $size = 'full', $post = 0 ) {
	$thumb = lj_get_posthumbnail( $post );
	$url = $size === 'full' ? $thumb['url'] : $thumb['sizes'][$size];

	return $url;
}

/**
 * List terms from a taxonomy for any post
 * @param  str  $tax  The name of the taxonomy
 * @param  mxd  $post The post object
 * @return str        The terms as text
 */
function lj_list_terms( $tax, $post = 0 ) {
	$terms_as_text = get_the_term_list( $post, $tax, '', ', ' );
	if( ! empty( $terms_as_text ) ) echo strip_tags( $terms_as_text );
}

/**
 * Create custom post type labels
 * @param  str $singular Singular name
 * @param  str $plural   Plural name, leave blank to append 's' to singular
 * @return array         Full list of required labels
 */
function post_type_labels( $singular, $plural = null ) {

	if ( $plural === null ) {
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
function lj_hex_is_light( $color ) {
    $hex = str_replace( '#', '', $color );

    $c_r = hexdec( substr( $hex, 0, 2 ) );
    $c_g = hexdec( substr( $hex, 2, 2 ) );
    $c_b = hexdec( substr( $hex, 4, 2 ) );

    $brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

    return $brightness > 155;
}