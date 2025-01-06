<?php
/*
Plugin Name: Arab Fund
Plugin URI: https://www.arabfund.org/
Description: Custom development and enhancements of new features for Arab Funds
Version: 1.0.0
Author: Arab Funds
Author URI: https://www.arabfund.org
*/

/**
 * Basic plugin definitions 
 * 
 * @package Arab Funds
 * @since 1.0.0
 */
if( !defined( 'ARAB_FUNDS_DIR' ) ) {
  define( 'ARAB_FUNDS_DIR', dirname( __FILE__ ) );      // Plugin dir
}
if( !defined( 'ARAB_FUNDS_VERSION' ) ) {
  define( 'ARAB_FUNDS_VERSION', '1.0.3' );      // Plugin Version
}
if( !defined( 'ARAB_FUNDS_URL' ) ) {
  define( 'ARAB_FUNDS_URL', plugin_dir_url( __FILE__ ) );   // Plugin url
}
if( !defined( 'ARAB_FUNDS_INC_DIR' ) ) {
  define( 'ARAB_FUNDS_INC_DIR', ARAB_FUNDS_DIR.'/includes' );   // Plugin include dir
}
if( !defined( 'ARAB_FUNDS_INC_URL' ) ) {
  define( 'ARAB_FUNDS_INC_URL', ARAB_FUNDS_URL.'includes' );    // Plugin include url
}
if( !defined( 'ARAB_FUNDS_ADMIN_DIR' ) ) {
  define( 'ARAB_FUNDS_ADMIN_DIR', ARAB_FUNDS_INC_DIR.'/admin' );  // Plugin admin dir
}
if(!defined('ARAB_FUNDS_PREFIX')) {
  define('ARAB_FUNDS_PREFIX', 'arab_funds'); // Plugin Prefix
}
if(!defined('ARAB_FUNDS_VAR_PREFIX')) {
  define('ARAB_FUNDS_VAR_PREFIX', '_arab_funds_'); // Variable Prefix
}
if(!defined('ARAB_FUNDS_POST_TYPE_COUNTRY')) {
	define('ARAB_FUNDS_POST_TYPE_COUNTRY', 'arab_funds_country'); // Post Type for Country
}

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package Arab Funds
 * @since 1.0.0
 */
load_plugin_textdomain( 'arabfunds', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 *
 * @package Arab Funds
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'arab_funds_install' );

function arab_funds_install(){
	
}

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 *
 * @package Arab Funds
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'arab_funds_uninstall');

function arab_funds_uninstall(){
  
}

// Global variables
global $arab_funds_scripts, $arab_funds_admin, $arab_funds_shortcodes , $arab_funds_sakib_shortcodes;

include_once( ARAB_FUNDS_ADMIN_DIR.'/arab-funds-misc-functions.php' );

// Script class handles most of script functionalities of plugin
include_once( ARAB_FUNDS_INC_DIR.'/class-arab-funds-scripts.php' );
$arab_funds_scripts = new Arab_Funds_Scripts();
$arab_funds_scripts->add_hooks();

// Admin class handles most of admin panel functionalities of plugin
include_once( ARAB_FUNDS_ADMIN_DIR.'/class-arab-funds-admin.php' );
$arab_funds_admin = new Arab_Funds_Admin();
$arab_funds_admin->add_hooks();

// Shortcodes class handles all the shortcodes displayed on the front-end
include_once( ARAB_FUNDS_INC_DIR.'/public/class-arab-funds-shortcodes.php' );
$arab_funds_shortcodes = new Arab_Funds_Shortcodes();
$arab_funds_shortcodes->add_hooks();

include_once( ARAB_FUNDS_INC_DIR.'/public/class-sakib-shortcodes.php' );
$arab_funds_sakib_shortcodes = new Sakib_Shortcodes();
$arab_funds_sakib_shortcodes->add_hooks();



// Registring Post type functionality
require_once( ARAB_FUNDS_INC_DIR.'/arab-funds-post-type.php' );


?>