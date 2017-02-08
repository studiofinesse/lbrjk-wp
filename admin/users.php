<?php

/**
 * Conditional check for the current user role
 * @param  array $roles List of roles to check
 * @return bool         Does query match current user role
 */
function current_user_role_is($roles) {
	// Current user object
	$user = wp_get_current_user();
	// Array of roles to check for
	$allowed_roles = array($roles);

	// If roles is matched in array return true, otherwise return false
	if(array_intersect($allowed_roles, $user->roles)) {
		return true;
	}
	return false;
}