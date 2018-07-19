<?php

function lj_social_links() {
	$accounts = get_field('social_media_accounts', 'option');

	if($accounts) {
		echo '<ul class="social-icons">';
		foreach($accounts as $account) {
			echo '<li><a href="' . $account['social_media_account_url'] . '">' . $account['social_media_account']['label'] . '</a></li>';
		}
		echo '</ul>';
	}
}

function lj_social_icons($colors = false) {
	$accounts = get_field('social_media_accounts', 'option');

	if($accounts) {
		echo $colors ? '<div class="social-icons social-icons--branded">' : '<div class="social-icons">';
		echo '<ul>';
		foreach($accounts as $account) {
			echo '<li class="icon icon--' . $account['social_media_account']['value'] . '">';
			echo '<a href="' . $account['social_media_account_url'] . '" title="Find us on ' . $account['social_media_account']['label'] . '">';
			echo file_get_contents( plugin_dir_url( '', __FILE__ ) . 'lbrjk-wp/assets/img/icon-' . $account['social_media_account']['value'] . '.svg' );
			echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}
}