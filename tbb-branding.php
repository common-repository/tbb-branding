<?php

/*
 * Plugin Name: The Blackest Box's Branding
 * Plugin URI: http://wordpress.org/extend/plugins/tbb-branding/
 * Description: Overall 24 options can be configured for branding and customizing a WordPress installation.
 * Author: Sebastian Krüger
 * Version: 0.1.4
 * Author URI: http://theblackestbox.net
 * License: GPL2+
 * Text Domain: tbb-branding
 * Domain Path: /languages/
 */
define('TBB_BRANDING_VERSION','0.1.4');
define('TBB_BRANDING_PLUGIN_BASENAME',plugin_basename(__FILE__));

require_once dirname( __FILE__ ) . '/class.tbb-branding.php';

new TBBBranding();