<?php

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
		if( ! $has_prev ) echo '<span class="' . $class . '__prev disabled">' . $prev_text . '</span>';
		if( $has_prev ) echo '<a href="' . $prev_link . '" class="' . $class . '__prev">' . $prev_text . '</a>';
		if( $has_next ) echo '<a href="' . $next_link . '" class="' . $class . '__next">' . $next_text . '</a>';
		if( ! $has_next ) echo '<span class="' . $class . '__next disabled">' . $next_text . '</span>';
		echo '</div>';

	}

}