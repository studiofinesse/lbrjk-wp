<?php

// Deletes all CSS classes and id's, except for those listed in the array below
function custom_wp_nav_menu($var, $item = null) {
	if(is_array($var)) {
		if(in_array('current_page_parent', $var) && is_object($item) && 'post_type' == $item->type && (is_single() && ! is_singular('post') || is_tax() || is_post_type_archive()) && $item->object_id == (int) get_option('page_for_posts')) {
			while (false !== $k = array_search('current_page_parent', $var))
				unset($var[ $k ]);
		}

		$var = array_intersect($var, array(
			// List of allowed menu classes
			// 'current_page_item',
			'current_page_parent',
			'current_page_ancestor',
			'current-menu-item',
			'first',
			'last',
			'vertical',
			'horizontal'
			)
		);
	} else {
		$var = '';
	}

	return $var;
}

add_filter('nav_menu_css_class', 'custom_wp_nav_menu', 10, 2);
add_filter('nav_menu_item_id', 'custom_wp_nav_menu');
add_filter('page_css_class', 'custom_wp_nav_menu');

// Replaces "current-menu-item" with "active"
function current_to_active($text){

	$replace = array(
		// List of menu item classes that should be changed to "active"
		// 'current_page_item' => 'active-page',
		'current_page_parent' => 'parent-active',
		// 'current_page_ancestor' => 'active',
		'current-menu-item' => 'active'
	);

	$text = str_replace(array_keys($replace), $replace, $text);
	return $text;
}

add_filter ('wp_nav_menu','current_to_active');

// Removes empty classes and removes the sub menu class
function strip_empty_classes($menu){

	$menu = preg_replace('/ class=""| class="sub-menu"/','',$menu);
	return $menu;

}

add_filter ('wp_nav_menu','strip_empty_classes');

/**
 * Update options from wp_nav_menu to
 * output cleanest markup possible
 * @param  string $location Theme location of menu required
 * @return string           Markup of menu
 */
function clean_nav_menu($location, $class = null) {

	if($class != null) {
		$items_wrap = '<ul class="' . $class . '">%3$s</ul>';
	} else {
		$items_wrap = '<ul>%3$s</ul>';
	}

	$args = array(
		'theme_location'  => $location,
		'menu'            => '',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => '',
		'menu_id'         => '',
		'items_wrap'      => $items_wrap
	);

	echo wp_nav_menu($args);
}

/**
 * Return raw list of links from a
 * wp_nav_menu by passing theme location
 * @param  string $location Name of the menu
 * @return string           List of anchor tags
 */
function menu_item_links($location, $list_items = true) {
	if(($locations = get_nav_menu_locations()) && isset($locations[$location])) {
		$menu = wp_get_nav_menu_object($locations[$location]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		foreach((array) $menu_items as $key => $menu_item) {
			$url = $menu_item->url;
			$title = $menu_item->title;
			if($list_items) { echo '<li>'; }
			echo '<a href="'. $url .'">'. $title .'</a>' ."\n";
			if($list_items) { echo '</li>'; }
		}
	}
}