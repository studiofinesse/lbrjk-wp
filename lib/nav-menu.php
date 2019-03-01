<?php

if( ! defined('ABSPATH' ) ) exit;

// Deletes all CSS classes and id's, except for those listed in the array below
function lj_nav_menu_cleanup( $var, $item = null ) {
	if( is_array( $var ) ) {
		if( in_array( 'current_page_parent', $var ) && is_object( $item ) && 'post_type' == $item->type && ( is_single() && ! is_singular( 'post' ) || is_tax() || is_post_type_archive() ) && $item->object_id == ( int ) get_option( 'page_for_posts' ) ) {
			while ( false !== $k = array_search( 'current_page_parent', $var ) )
				unset( $var[ $k ] );
		}

		$classes = [
			'current_page_parent',
			'current-page-ancestor',
			'current-menu-item',
			'first',
			'last',
			'vertical',
			'horizontal'
		];

		$var = array_intersect( $var, apply_filters( 'lj_nav_allowed_classes', $classes ) );
	} else {
		$var = '';
	}

	return $var;
}

add_filter( 'nav_menu_css_class', 'lj_nav_menu_cleanup', 10, 2 );
add_filter( 'nav_menu_item_id', 'lj_nav_menu_cleanup' );
add_filter( 'page_css_class', 'lj_nav_menu_cleanup' );

// Replaces "current-menu-item" with "active"
function lj_nav_menu_active_class( $text ){

	$replace = array(
		// List of menu item classes that should be changed to "active"
		// 'current_page_item' => 'active-page',
		'current_page_parent' => 'active',
		'current-page-ancestor' => 'active',
		'current-menu-item' => 'active'
	 );

	$text = str_replace( array_keys( $replace ), $replace, $text );
	return $text;
}

add_filter ( 'wp_nav_menu','lj_nav_menu_active_class' );

// Removes empty classes and removes the sub menu class
function lj_nav_menu_strip_empty_classes( $menu ) {
	$menu = preg_replace( '/ class=""| class="sub-menu"/','',$menu );
	return $menu;
}

add_filter ( 'wp_nav_menu','lj_nav_menu_strip_empty_classes' );

/**
 * Output a navigation menu with minimal pre-defined classes and IDs
 * @param  str  $theme_location The menu location slug
 * @param  str  $class          Optionally add classes to the underordered list element
 * @return str                  The menu markup
 */
function lj_nav_menu( $theme_location, $class = '' ) {

	$items_wrap = $class ? '<ul class="' . $class . '">%3$s</ul>' : '<ul>%3$s</ul>';

	$args = array(
		'theme_location'  => $theme_location,
		'menu'            => '',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => '',
		'menu_id'         => '',
		'items_wrap'      => $items_wrap
	 );

	echo wp_nav_menu( $args );
}

/**
 * Return a clean list of links from a navigation menu
 * @param  str  $location   The menu location slug
 * @param  bool $list_items Optionally wrap each items in a list item
 * @return str              Markup of links
 */
function lj_nav_menu_links( $location, $list_items = true ) {
	if( ( $locations = get_nav_menu_locations() ) && isset( $locations[$location] ) ) {

		$menu = wp_get_nav_menu_object( $locations[$location] );
		$menu_items = wp_get_nav_menu_items( $menu->term_id );

		foreach( ( array ) $menu_items as $key => $menu_item ) {
			if( $list_items ) echo '<li>';
			echo '<a href="' . $menu_item->url . '">'. $menu_item->title . '</a>' . "\n";
			if( $list_items ) echo '</li>';
		}

	}
}