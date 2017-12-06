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

function lj_social_icons() {
	$accounts = get_field('social_media_accounts', 'option');

	if($accounts) {
		echo '<div class="social-icons">';
		echo '<ul>';
		foreach($accounts as $account) {
			echo '<li class="icon icon--' . $account['social_media_account']['value'] . '">';
			echo '<a href="' . $account['social_media_account_url'] . '" title="Find us on ' . $account['social_media_account']['label'] . '">';
			echo file_get_contents(plugins_url('../assets/img', __FILE__) . '/icon-' . $account['social_media_account']['value'] . '.svg');
			echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}
}