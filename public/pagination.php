<?php

if ( ! defined( 'ABSPATH') ) exit;

/**
 * Simple next/previous links
 * for blog archive and single posts
 * @param  string $class Class for wrapping div and BEM prefix for inner elements
 * @return string        Simple markup
 */
function lj_prev_next_pagination( $class = 'post-pagination' ) {

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
		echo '<div class="' . $class . '">';
		echo $has_prev ? '<a href="' . $prev_link . '" class="prev">' . $prev_text . '</a>' : '<span class="prev disabled">' . $prev_text . '</span>';
		echo $has_next ? '<a href="' . $next_link . '" class="next">' . $next_text . '</a>' : '<span class="next disabled">' . $next_text . '</span>';
		echo '</div>';
	}

}