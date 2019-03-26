<?php

if ( ! defined( 'ABSPATH') ) exit;

/**
 * Return a text list of the company social accounts
 * @return str An unordered list of links
 */
function lj_social_account_links( $list_items = false ) {
	$accounts = get_field( 'social_media_accounts', 'option' );

	if( $accounts ) {
		foreach( $accounts as $account ) {
			if( $list_items ) echo '<li>';
			echo '<a href="' . $account['social_media_account_url'] . '">' . $account['social_media_account']['label'] . '</a>';
			if( $list_items ) echo '</li>';
		}
	}
}

/**
 * Return a list of brand svg icons of the company social accounts
 * @param  bool $colors Optionally brand the icons
 * @return str          An unordered list of links/icons
 */
function lj_social_account_icons( $colors = false ) {
	$accounts = get_field( 'social_media_accounts', 'option' );

	if( $accounts ) {
		echo $colors ? '<div class="social-icons social-icons--branded">' : '<div class="social-icons">';
		echo '<ul>';
		foreach( $accounts as $account ) {
			echo '<li class="icon icon--' . $account['social_media_account']['value'] . '">';
			echo '<a href="' . $account['social_media_account_url'] . '" title="Find us on ' . $account['social_media_account']['label'] . '">';
			echo file_get_contents(  plugin_dir_url(  '', __FILE__  ) . 'lbrjk-wp/assets/img/icon-' . $account['social_media_account']['value'] . '.svg'  );
			echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}
}