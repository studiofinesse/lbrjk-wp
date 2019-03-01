<?php

if( ! defined('ABSPATH' ) ) exit;

/**
 * Customise admin footer text
 * to prompt action when needing support
 * @return string The updated text
 */
function lj_admin_footer_text() {
	echo '<em>Website developed by <a href="http://www.lbrjk.com">Lumberjack</a>. Contact <a href="mailto:support@lbrjk.com">support@lbrjk.com</a> for support</em>';
}
add_filter( 'admin_footer_text', 'lj_admin_footer_text' );

/**
 * Clean up admin bar
 */
function lj_clean_admin_bar() {
	global $wp_admin_bar;

	/* Remove their stuff */
	$wp_admin_bar->remove_menu( 'wp-logo' );
	$wp_admin_bar->remove_menu( 'comments' );

	// Remove 'How are you <user>? text'
	$user_id = get_current_user_id();
	$avatar = get_avatar(  $user_id, 16  );
	$wp_admin_bar->add_menu(  array(
		'id' => 'my-account',
		'title' => ' ' . $avatar  )
	 );
}
add_action( 'wp_before_admin_bar_render', 'lj_clean_admin_bar', 0 );

/**
 * Update name of posts in admin menu
 */
function lj_rename_blog() {
	$title = 'News';
	global $menu;
	$menu[5][0] = apply_filters( 'lj_name_blog', $title );
}
add_action( 'admin_menu', 'lj_rename_blog' );

/**
 * Update the blog description with custom field
 * Also reduce chance of 'Just another WordPress' site being displayed
 * @param  str $text   The current text
 * @param  mixed $show The type of information requested
 * @return str         New description
 */
function update_blog_description( $text, $show ) {
	$tagline = get_company_info( 'tagline' );

    if ( 'description' == $show ) {
        if( $tagline ) {
			$text = $tagline;
		} else {
			if( $text != 'Just another WordPress site' ) {
				$text = $text;
			} else {
				$text = '';
			}
		}
    }
    return $text;
}

add_filter( 'bloginfo', 'update_blog_description', 10, 2 );