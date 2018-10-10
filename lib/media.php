<?php

/**
 * Set default options when inserting media
 */
function lj_media_config() {
	update_option( 'image_default_align', 'none' ); // No alignment
	update_option( 'image_default_link_type', 'none' ); // No link
	update_option( 'image_default_size', 'large' ); // Full size

	// Update default image sizes to something more usable
	update_option( 'thumbnail_size_w', 300 ); // thumbnail width
	update_option( 'thumbnail_size_h', 300 ); // thumbnail height
	update_option( 'medium_size_w', 800 ); // medium width
	update_option( 'medium_size_h', 9999 ); // medium height
	update_option( 'large_size_w', 1200 ); // large width
	update_option( 'large_size_h', 9999 ); // large height

}
add_action( 'after_setup_theme', 'lj_media_config' );

/**
 * Wrap images ( & their links ) in .post-image containers, and move any custom
 * image classes to the container.
 */
function lj_post_image_markup( $html ) {
	return preg_replace_callback( '/^( <[pa][^>]*> )*<img[^>]+>( <\/[pa]> )*$/m', function ( $match ) {
		$image = strip_tags( $match[0], '<a><img>' );

		if( preg_match( '/ class=["\']( .+? )["\']/', $image, $class ) ) {
			$image = str_replace( $class[0], '', $image );
			$class = trim( $class[1] );
			if( strlen( $class ) ) {
				$class = " $class";
			}
		} else {
			$class = '';
		}

		return "\n<figure class='post-image$class'>$image</figure>\n";
	}, $html );
}
add_filter( 'the_content', 'lj_post_image_markup' );

/**
 * Custom caption HTML, moves any custom classes on image to the container.
 */
function lj_post_caption_markup( $html, $attr, $image ) {
	$atts = shortcode_atts( [
		'caption' => '',
		'align'      => 'alignnone',
		'class'   => '',
	], $attr, 'caption' );

	if( preg_match( '/ class=["\']( .+? )["\']/', $image, $class ) ) {
		$image = str_replace( $class[0], '', $image );
		$class = $class[1];
	} else {
		$class = '';
	}

	$class = "$class {$atts['class']} {$atts['align']}";
	$class = explode( ' ', $class );
	$class = array_unique( $class );
	$class = array_map( 'trim', $class );
	$class = array_filter( $class );
	$class = implode( ' ', $class );

	if( strlen( $class ) ) {
		$class = " $class";
	}

	return <<<html

<figure class="post-image post-image--w-caption$class">
	$image
	<figcaption>{$atts['caption']}</figcaption>
</figure>

html;
}
add_filter( 'img_caption_shortcode', 'lj_post_caption_markup', 10, 3 );