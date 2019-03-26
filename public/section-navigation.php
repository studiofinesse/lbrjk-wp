<?php

if ( ! defined( 'ABSPATH') ) exit;

function lj_get_section_items() {

	global $post;
	$pages = [];

	if( $post ) {

		// Better name for the current page
		$current_page = $post->ID;
		// Check to see if page has a parent
		$parent_page = $post->post_parent;
		// Get current page's children ( if any )
		$page_children = get_pages( 'child_of=' . $current_page );
		// Check if page has children
		$has_children = count( $page_children ) != 0;
		// Get the siblings ( if any )
		$page_siblings = get_pages( 'child_of=' . $parent_page . '&exclude=' . $current_page );
		// Check if page has siblings
		$has_siblings = ( $parent_page != 0 && count( $page_siblings ) != 0 );

		// If page has children assign $pages to children
		// otherwise get the siblings instead
		if( $has_children ) {
			$child_of = $current_page;
		} else {
			$child_of = $parent_page;
		}

		if( $has_children || $has_siblings ) {
			$pages = get_pages( array(
				'sort_column' => 'menu_order',
				'child_of' => $child_of,
				'exclude' => $current_page
			) );
		}
	}

	return $pages;

}

/**
 * Output an unordered list of either
 * the current page's children or siblings
 * @param  string $class Class name for ul, default 'section-nav'
 * @return mixed        The list including items
 */
function lj_section_items( $class = 'section-nav' ) {

	global $post;

	if( $post ) {

		// Better name for the current page
		$current_page = $post->ID;
		// Check to see if page has a parent
		$parent_page = $post->post_parent;
		// Get current page's children ( if any )
		$page_children = get_pages( 'child_of=' . $current_page );
		// Check if page has children
		$has_children = count( $page_children ) != 0;
		// Get the siblings ( if any )
		$page_siblings = get_pages( 'child_of=' . $parent_page . '&exclude=' . $current_page );
		// Check if page has siblings
		$has_siblings = ( $parent_page != 0 && count( $page_siblings ) != 0 );

		// If page has children assign $pages to children
		// otherwise get the siblings instead
		if( $has_children ) {
			$child_of = $current_page;
		} else {
			$child_of = $parent_page;
		}

		// Arguements for wp_list_pages
		$args = array(
			'title_li' => '',
			'depth'    => 1,
			'child_of' => $child_of,
			'exclude'  => $current_page
		);

		// Output unordered list of children or siblings, if present,
		// with designated class name for list
		if( $has_children || $has_siblings ) {
			echo '<ul class="' . $class . '">';
			if( $parent_page ) { echo '<li class="' . $class . '__parent"><a href="' . get_permalink( $parent_page ) . '">' . get_the_title( $parent_page ) . '</a></li>'; }
			wp_list_pages( $args );
			echo '</ul>';
		}

	}

}