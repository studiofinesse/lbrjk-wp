<?php

/**
* @wordpress-plugin
* Plugin Name:       LBRJK
* Plugin URI:        http://lbrjk.com
* Description:       Just the core functionality that we like to use with most WordPress installs
* Version:           1.0.0
* Author:            Lumberjack
* Author URI:        http://lbrjk.com/
 */

// Define constants
define('LBRJK_DIR', dirname(__FILE__)); // e.g /var/www/...
define('LBRJK_URL', plugins_url('', __FILE__)); // e.g http://...

include_once('admin/admin.php');
include_once('admin/editor.php');
include_once('admin/login.php');
include_once('admin/users.php');

include_once('lib/lbrjk-functions.php');
include_once('lib/lbrjk-setup.php');
include_once('lib/media.php');
include_once('lib/nav-menu.php');

include_once('public/breadcrumbs.php');
include_once('public/excerpts.php');
include_once('public/pagination.php');
include_once('public/section-navigation.php');