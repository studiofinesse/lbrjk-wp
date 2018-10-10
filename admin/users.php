<?php

/*
 * Get user's role
 *
 * If $user parameter is not provided, returns the current user's role.
 * Only returns the user's first role, even if they have more than one.
 * Returns false on failure.
 *
 * @param  mixed       $user User ID or object.
 * @return string|bool       The User's role, or false on failure.
 */
function get_user_role( $user = null ) {
	$user = $user ? new WP_User( $user ) : wp_get_current_user();
	return $user->roles ? $user->roles[0] : 'guest';
}

/**
 * Conditional check for the current user role
 * @param  array $roles List of roles to check
 * @return bool         Does query match current user role
 */
function current_user_role_is( $roles ) {
	// Current user object
	$user = wp_get_current_user();
	// Array of roles to check for
	$allowed_roles = array( $roles );

	// If roles is matched in array return true, otherwise return false
	if( array_intersect( $allowed_roles, $user->roles ) ) {
		return true;
	}
	return false;
}