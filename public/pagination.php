<?php

if ( ! defined( 'ABSPATH') ) exit;

/**
 * Simple next/previous links
 * for blog archive and single posts
 * @param  string $class Class for wrapping div and BEM prefix for inner elements
 * @return string        Simple markup
 */
function lj_prev_next_pagination( $args = null ) {

	$defaults = array(
		'wrapper_class' => 'post-pagination',
		'prev_arrow' => '',
		'next_arrow' => '',
	);

	$args = wp_parse_args( $args, $defaults );

	global $paged;
	global $wp_query;

	$pages = $wp_query->max_num_pages;
	$has_prev = $paged > 1;
	$prev_link = get_previous_posts_page_link();
	$prev_text = 'Newer Posts';
	$has_next = $paged < $pages;
	$next_link = get_next_posts_page_link();
	$next_text = 'Older Posts';

	if( $pages > 1 ) {
		echo '<div class="' . $args['wrapper_class'] . '">';

		if( $has_prev ) {
			echo '<a href="' . $prev_link . '">';
			echo $args['prev_arrow'];
			echo '<span>' . $prev_text . '</span>';
			echo '</a>';
		} else {
			echo '<span class="disabled">';
			echo $args['prev_arrow'];
			echo '<span>' . $prev_text . '</span>';
			echo '</span>';
		}

		if( $has_next ) {
			echo '<a href="' . $next_link . '">';
			echo '<span>' . $next_text . '</span>';
			echo $args['next_arrow'];
			echo '</a>';
		} else {
			echo '<span class="disabled">';
			echo '<span>' . $next_text . '</span>';
			echo $args['next_arrow'];
			echo '</span>';
		}

		echo '</div>';
	}

}